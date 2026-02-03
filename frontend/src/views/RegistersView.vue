<script setup lang="ts">
import { ref, onMounted, computed } from "vue";

import { storeToRefs } from "pinia";
import PageLayout from "@/layouts/PageLayout.vue";
import StudentsTable from "@/components/students/StudentsTable.vue";
import { useStudentStore } from "@/stores/student.store";
import { subjectService, type Subject } from "@/services/subject.service";
import { semesterService, type Semester } from "@/services/semester.service";
import { registerService } from "@/services/register.service";
import type { Student } from "@/interfaces/Student";
import { Search, Loader2 } from "lucide-vue-next";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/common/select";
import Button from "@/components/common/Button.vue";
import Alert from "@/components/common/Alert.vue";

const studentStore = useStudentStore();
const {
  students,
  pagination,
  loading: studentsLoading,
} = storeToRefs(studentStore);

// Form State
const selectedStudent = ref<Student | null>(null);
const selectedSubjectId = ref<string>("");
const selectedSemesterId = ref<string>("");
const grade = ref<number | null>(null);

// Data State
const subjects = ref<Subject[]>([]);
const semesters = ref<Semester[]>([]);

// UI State
const search = ref("");
const debouncedSearch = ref("");
const loadingData = ref(false);
const submitting = ref(false);
const successMessage = ref("");
const errorMessage = ref("");

// Fetch initial data
onMounted(async () => {
  try {
    loadingData.value = true;
    const [subjectsData, semestersData] = await Promise.all([
      subjectService.getAll(),
      semesterService.getAll(),
    ]);
    subjects.value = subjectsData;
    semesters.value = semestersData;
  } catch (error) {
    console.error("Failed to load form data", error);
    errorMessage.value =
      "Error cargando datos del formulario. Por favor recarga la página.";
  } finally {
    loadingData.value = false;
  }

  // Initial fetch for students
  fetchStudents(1, 10, "");
});

// Student Search Logic
let debounceTimeout: ReturnType<typeof setTimeout>;
const onSearchInput = (event: Event) => {
  const target = event.target as HTMLInputElement;
  search.value = target.value;

  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(() => {
    debouncedSearch.value = search.value;
    fetchStudents(1, 10, search.value);
  }, 500);
};

const fetchStudents = (page: number, limit: number, search: string) => {
  studentStore.fetchStudents(page, limit, search);
};

const handlePageChange = (newPage: number) => {
  const limit = pagination.value?.per_page || 10;
  fetchStudents(newPage, limit, search.value);
};

const handleLimitChange = (newLimit: number) => {
  fetchStudents(1, newLimit, search.value);
};

const selectStudent = (student: Student) => {
  selectedStudent.value = student;
};

const changeStudent = () => {
  selectedStudent.value = null;
  search.value = "";
  debouncedSearch.value = "";
  fetchStudents(1, 10, "");
};

// Submission Logic
const isValid = computed(() => {
  return (
    selectedStudent.value &&
    selectedSubjectId.value &&
    selectedSemesterId.value &&
    grade.value !== null &&
    grade.value >= 0 &&
    grade.value <= 10
  );
});

const submitRegister = async () => {
  if (!isValid.value || !selectedStudent.value) return;

  try {
    submitting.value = true;
    successMessage.value = "";
    errorMessage.value = "";

    await registerService.create({
      student_id: selectedStudent.value.id,
      subject_id: parseInt(selectedSubjectId.value),
      semester_id: parseInt(selectedSemesterId.value),
      grade: grade.value!,
    });

    successMessage.value = "Nota registrada exitosamente";

    // Reset form
    selectedStudent.value = null;
    selectedSubjectId.value = "";
    selectedSemesterId.value = "";
    grade.value = null;
    search.value = "";
    fetchStudents(1, 10, "");

    // Auto-hide success message
    setTimeout(() => {
      successMessage.value = "";
    }, 3000);
  } catch (error: any) {
    console.error("Failed to register grade", error);
    errorMessage.value =
      error.response?.data?.message || "Error al registrar la nota";
  } finally {
    submitting.value = false;
  }
};
</script>

<template>
  <PageLayout title="Registro de Notas">
    <div class="w-full mx-auto space-y-6">
      <!-- Messages -->
      <!-- Messages -->
      <Alert v-if="successMessage" variant="success" class="mb-4">
        {{ successMessage }}
      </Alert>

      <Alert v-if="errorMessage" variant="error" class="mb-4">
        {{ errorMessage }}
      </Alert>

      <div class="bg-card p-4 md:p-6 rounded-lg border shadow-sm space-y-6">
        <h2 class="text-lg font-semibold">Nuevo registro</h2>

        <!-- Step 1: Select Student -->
        <div class="space-y-4">
          <label
            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
          >
            Estudiante
          </label>

          <div
            v-if="selectedStudent"
            class="flex items-center justify-between p-4 border rounded-md bg-muted/20"
          >
            <div>
              <p class="font-medium">
                {{ selectedStudent.name }} {{ selectedStudent.lastname }}
              </p>
              <p class="text-sm text-muted-foreground">
                {{ selectedStudent.carnet }} - {{ selectedStudent.career }}
              </p>
            </div>
            <Button variant="outline" size="sm" @click="changeStudent"
              >Cambiar</Button
            >
          </div>

          <div v-else class="space-y-4">
            <div class="relative w-full sm:w-[300px]">
              <Search
                class="absolute left-2 top-2.5 h-4 w-4 text-muted-foreground"
              />
              <input
                :value="search"
                @input="onSearchInput"
                placeholder="Buscar por nombre, apellido o carnet..."
                class="pl-8 h-10 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
              />
            </div>

            <div>
              <StudentsTable
                :data="students"
                :page="pagination?.current_page || 1"
                :total-pages="pagination?.last_page || 1"
                :limit="pagination?.per_page || 10"
                :loading="studentsLoading"
                :selectable="true"
                @update:page="handlePageChange"
                @update:limit="handleLimitChange"
                @select="selectStudent"
              />
            </div>
          </div>
        </div>

        <div
          v-if="selectedStudent"
          class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t"
        >
          <!-- Step 2: Select Subject -->
          <div class="space-y-2">
            <label class="text-sm font-medium leading-none">Materia</label>
            <Select v-model="selectedSubjectId">
              <SelectTrigger>
                <SelectValue placeholder="Seleccionar materia" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem
                  v-for="subject in subjects"
                  :key="subject.id"
                  :value="subject.id.toString()"
                >
                  {{ subject.name }} ({{ subject.code }})
                </SelectItem>
              </SelectContent>
            </Select>
          </div>

          <!-- Step 3: Select Semester -->
          <div class="space-y-2">
            <label class="text-sm font-medium leading-none">Semestre</label>
            <Select v-model="selectedSemesterId">
              <SelectTrigger>
                <SelectValue placeholder="Seleccionar ciclo" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem
                  v-for="semester in semesters"
                  :key="semester.id"
                  :value="semester.id.toString()"
                >
                  {{ semester.year }} - Ciclo {{ semester.semester_number }}
                </SelectItem>
              </SelectContent>
            </Select>
          </div>

          <!-- Step 4: Grade -->
          <div class="space-y-2">
            <label class="text-sm font-medium leading-none"
              >Nota (0 - 10)</label
            >
            <input
              v-model.number="grade"
              type="number"
              min="0"
              max="10"
              step="0.01"
              placeholder="Ej: 8.5"
              class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            />
          </div>
        </div>

        <div class="flex justify-end pt-6">
          <Button
            @click="submitRegister"
            :disabled="!isValid || submitting"
            class="w-full sm:w-auto"
          >
            <Loader2 v-if="submitting" class="mr-2 h-4 w-4 animate-spin" />
            Crear registro
          </Button>
        </div>
      </div>
    </div>
  </PageLayout>
</template>
