<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import { StudentService } from "@/services/student.service";
import type { StudentRegister } from "@/interfaces/AcademicRecord";

import PageLayout from "@/layouts/PageLayout.vue";
import Button from "@/components/common/Button.vue";
import Alert from "@/components/common/Alert.vue";
import { FileQuestion, Printer, Mail, Loader2 } from "lucide-vue-next";

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/common/table";

const route = useRoute();
const registers = ref<StudentRegister[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

const studentId = route.params.id as string;

// Fetch data
const fetchRegisters = async () => {
  loading.value = true;
  error.value = null;
  try {
    const response = await StudentService.getRegisters(Number(studentId));

    if (response.data) {
      registers.value = response.data;
    } else {
      registers.value = [];
    }
  } catch (err: any) {
    if (err.response && err.response.status === 404) {
      // Handle 404 as empty list
      registers.value = [];
    } else {
      error.value = "Error al cargar el expediente académico.";
      console.error(err);
    }
  } finally {
    loading.value = false;
  }
};

const printing = ref(false);
const emailing = ref(false);
const emailSuccess = ref("");
const emailError = ref("");

const handleEmail = async () => {
  try {
    emailing.value = true;
    emailSuccess.value = "";
    emailError.value = "";
    await StudentService.sendTranscriptEmail(studentId);
    emailSuccess.value = "Correo enviado exitosamente";
    setTimeout(() => {
      emailSuccess.value = "";
    }, 3000);
  } catch (err) {
    console.error("Error sending transcript email:", err);
    emailError.value = "Error al enviar el correo";
  } finally {
    emailing.value = false;
  }
};

const handlePrint = async () => {
  try {
    printing.value = true;
    const blob = await StudentService.getTranscript(studentId);

    // Create a Blob URL
    const url = window.URL.createObjectURL(
      new Blob([blob as any], { type: "application/pdf" }),
    );

    // Create an invisible iframe to print
    const iframe = document.createElement("iframe");
    iframe.style.display = "none";
    iframe.src = url;
    document.body.appendChild(iframe);

    iframe.onload = () => {
      iframe.contentWindow?.print();
      // Clean up after print dialog closes
      setTimeout(() => {
        document.body.removeChild(iframe);
        window.URL.revokeObjectURL(url);
      }, 10000);
    };
  } catch (err) {
    console.error("Error printing transcript:", err);
  } finally {
    printing.value = false;
  }
};

// Group by semester
const groupedRegisters = computed(() => {
  const groups: Record<
    string,
    {
      semesterName: string;
      year: number;
      semesterNum: number;
      registers: StudentRegister[];
    }
  > = {};

  if (!registers.value) return [];

  registers.value.forEach((reg) => {
    // Key to group by unique semester
    const key = `${reg.semester.year}-${reg.semester.semester_number}`;

    if (!groups[key]) {
      const year = reg.semester.year;
      // Pad semester number with leading zero if needed
      const semesterNumString = reg.semester.semester_number
        .toString()
        .padStart(2, "0");

      groups[key] = {
        semesterName: `Ciclo ${semesterNumString}/${year}`,
        year: year,
        semesterNum: reg.semester.semester_number,
        registers: [],
      };
    }
    groups[key].registers.push(reg);
  });

  return Object.values(groups).sort((a, b) => {
    if (a.year !== b.year) {
      return b.year - a.year;
    }
    return b.semesterNum - a.semesterNum;
  });
});

onMounted(() => {
  fetchRegisters();
});
</script>

<template>
  <PageLayout title="Expediente Académico" back-route="/students">
    <template #actions>
      <div
        class="flex gap-2"
        v-if="!loading && registers && registers.length > 0"
      >
        <Button
          variant="outline"
          size="sm"
          class="gap-2"
          @click="handleEmail"
          :disabled="loading || emailing"
        >
          <Loader2 v-if="emailing" class="h-4 w-4 animate-spin" />
          <Mail v-else class="h-4 w-4" />
          <span class="hidden sm:inline">Enviar por correo</span>
        </Button>
        <Button
          size="sm"
          class="gap-2"
          @click="handlePrint"
          :disabled="loading || printing"
        >
          <Loader2 v-if="printing" class="h-4 w-4 animate-spin" />
          <Printer v-else class="h-4 w-4" />
          <span class="hidden sm:inline">Imprimir</span>
        </Button>
      </div>
    </template>

    <div class="w-full">
      <div v-if="emailSuccess || emailError" class="mb-6">
        <Alert v-if="emailSuccess" variant="success" class="mb-4">
          {{ emailSuccess }}
        </Alert>
        <Alert v-if="emailError" variant="error" class="mb-4">
          {{ emailError }}
        </Alert>
      </div>

      <div v-if="loading" class="text-center py-8">
        <p>Cargando notas...</p>
      </div>

      <div v-else-if="error" class="text-center py-8 text-red-500">
        {{ error }}
      </div>

      <div v-else class="space-y-8">
        <template v-if="!registers || registers.length === 0">
          <div
            class="flex flex-col items-center justify-center py-12 text-center"
          >
            <div class="rounded-full bg-muted p-4 mb-4">
              <FileQuestion class="h-10 w-10 text-muted-foreground" />
            </div>
            <h3 class="text-xl font-semibold">No hay registros</h3>
            <p class="text-muted-foreground mt-2 max-w-sm">
              Este estudiante aún no tiene asignaturas registradas en su
              expediente académico.
            </p>
          </div>
        </template>

        <div
          v-for="group in groupedRegisters"
          :key="group.semesterName"
          class="rounded-lg border bg-card text-card-foreground shadow-sm"
        >
          <div class="flex flex-col space-y-1.5 p-6 pb-2">
            <h3 class="font-semibold leading-none tracking-tight text-xl">
              {{ group.semesterName }}
            </h3>
          </div>
          <div class="p-6 pt-0">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead class="w-[100px]">Código</TableHead>
                  <TableHead>Materia</TableHead>
                  <TableHead class="w-16 text-center">UV</TableHead>
                  <TableHead class="w-24 text-right">Nota</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="reg in group.registers" :key="reg.id">
                  <TableCell class="font-medium">{{
                    reg.subject.code
                  }}</TableCell>
                  <TableCell>{{ reg.subject.name }}</TableCell>
                  <TableCell class="text-center">{{
                    reg.subject.uv
                  }}</TableCell>
                  <TableCell class="text-right">
                    <span
                      :class="[
                        'inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2',
                        reg.grade >= 6
                          ? 'border-transparent bg-primary text-primary-foreground shadow hover:bg-primary/80'
                          : 'border-transparent bg-destructive text-primary-foreground shadow hover:bg-destructive/80',
                      ]"
                    >
                      {{ reg.grade }}
                    </span>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>
        </div>
      </div>
    </div>
  </PageLayout>
</template>
