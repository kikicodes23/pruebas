<script setup lang="ts">
import { ref } from "vue";
import { z } from "zod";
import { useStudentStore } from "@/stores/student.store";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
  DialogClose,
} from "@/components/common/dialog";
import Button from "@/components/common/Button.vue";
import { Plus } from "lucide-vue-next";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/common/select";
import { careers } from "@/constants/careers";
import Alert from "@/components/common/Alert.vue";

const props = defineProps<{
  triggerClass?: string;
}>();

const open = ref(false);
const studentStore = useStudentStore();
const isLoading = ref(false);
const successMessage = ref("");
const errorMessage = ref("");

const formSchema = z.object({
  carnet: z.string().min(1, "El carnet es requerido"),
  name: z.string().min(1, "El nombre es requerido"),
  lastname: z.string().min(1, "El apellido es requerido"),
  email: z.string().email("Email inválido"),
  career: z.string().min(1, "La carrera es requerida"),
});

type FormValues = z.infer<typeof formSchema>;

const form = ref<FormValues>({
  carnet: "",
  name: "",
  lastname: "",
  email: "",
  career: "",
});

const errors = ref<Partial<Record<keyof FormValues, string>>>({});

const validate = () => {
  const result = formSchema.safeParse(form.value);
  if (!result.success) {
    const formatted = result.error.format();
    errors.value = {
      carnet: formatted.carnet?._errors[0],
      name: formatted.name?._errors[0],
      lastname: formatted.lastname?._errors[0],
      email: formatted.email?._errors[0],
      career: formatted.career?._errors[0],
    };
    return false;
  }
  errors.value = {};
  return true;
};

const handleSubmit = async () => {
  if (!validate()) return;

  isLoading.value = true;
  try {
    successMessage.value = "";
    errorMessage.value = "";
    await studentStore.createStudent(form.value);
    successMessage.value = "Estudiante creado exitosamente";

    // Reset form
    form.value = {
      carnet: "",
      name: "",
      lastname: "",
      email: "",
      career: "",
    };

    setTimeout(() => {
      open.value = false;
      successMessage.value = "";
    }, 1500);
  } catch (error: any) {
    console.error("Failed to submit", error);
    if (error.response && error.response.status === 400) {
      const validationErrors = error.response.data.errors;
      if (validationErrors) {
        // Map backend errors to form errors
        // We take the first error message for each field
        const newErrors: Partial<Record<keyof FormValues, string>> = {};
        for (const key in validationErrors) {
          if (Object.prototype.hasOwnProperty.call(validationErrors, key)) {
            newErrors[key as keyof FormValues] = validationErrors[key][0];
          }
        }
        errors.value = newErrors;
        errorMessage.value = "Error de validación, por favor revise los campos";
        return; // Don't show generic error
      }
    }
    errorMessage.value = "Error al crear el estudiante";
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <Dialog v-model:open="open">
    <DialogTrigger as-child>
      <Button :class="props.triggerClass">
        <Plus :size="16" class="mr-2" />
        Crear Estudiante
      </Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Crear Estudiante</DialogTitle>
        <DialogDescription>
          Ingresa los datos del nuevo estudiante. Haz clic en guardar cuando
          termines.
        </DialogDescription>
      </DialogHeader>

      <div class="grid gap-4 py-4">
        <Alert v-if="successMessage" variant="success" class="mb-4">
          {{ successMessage }}
        </Alert>
        <Alert v-if="errorMessage" variant="error" class="mb-4">
          {{ errorMessage }}
        </Alert>

        <div
          class="grid grid-cols-1 sm:grid-cols-4 items-start sm:items-center gap-2 sm:gap-4"
        >
          <label
            for="carnet"
            class="text-left sm:text-right text-sm font-medium"
          >
            Carnet
          </label>
          <div class="col-span-1 sm:col-span-3 w-full">
            <input
              id="carnet"
              v-model="form.carnet"
              class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
              :class="{ 'border-destructive': errors.carnet }"
            />
            <p v-if="errors.carnet" class="text-xs text-destructive mt-1">
              {{ errors.carnet }}
            </p>
          </div>
        </div>
        <div
          class="grid grid-cols-1 sm:grid-cols-4 items-start sm:items-center gap-2 sm:gap-4"
        >
          <label for="name" class="text-left sm:text-right text-sm font-medium">
            Nombre
          </label>
          <div class="col-span-1 sm:col-span-3 w-full">
            <input
              id="name"
              v-model="form.name"
              class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
              :class="{ 'border-destructive': errors.name }"
            />
            <p v-if="errors.name" class="text-xs text-destructive mt-1">
              {{ errors.name }}
            </p>
          </div>
        </div>
        <div
          class="grid grid-cols-1 sm:grid-cols-4 items-start sm:items-center gap-2 sm:gap-4"
        >
          <label
            for="lastname"
            class="text-left sm:text-right text-sm font-medium"
          >
            Apellido
          </label>
          <div class="col-span-1 sm:col-span-3 w-full">
            <input
              id="lastname"
              v-model="form.lastname"
              class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
              :class="{ 'border-destructive': errors.lastname }"
            />
            <p v-if="errors.lastname" class="text-xs text-destructive mt-1">
              {{ errors.lastname }}
            </p>
          </div>
        </div>
        <div
          class="grid grid-cols-1 sm:grid-cols-4 items-start sm:items-center gap-2 sm:gap-4"
        >
          <label
            for="email"
            class="text-left sm:text-right text-sm font-medium"
          >
            Email
          </label>
          <div class="col-span-1 sm:col-span-3 w-full">
            <input
              id="email"
              type="email"
              v-model="form.email"
              class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
              :class="{ 'border-destructive': errors.email }"
            />
            <p v-if="errors.email" class="text-xs text-destructive mt-1">
              {{ errors.email }}
            </p>
          </div>
        </div>
        <div
          class="grid grid-cols-1 sm:grid-cols-4 items-start sm:items-center gap-2 sm:gap-4"
        >
          <label
            for="career"
            class="text-left sm:text-right text-sm font-medium"
          >
            Carrera
          </label>
          <div class="col-span-1 sm:col-span-3 w-full">
            <Select v-model="form.career">
              <SelectTrigger :class="{ 'border-destructive': errors.career }">
                <SelectValue placeholder="Selecciona una carrera" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem
                  v-for="career in careers"
                  :key="career"
                  :value="career"
                >
                  {{ career }}
                </SelectItem>
              </SelectContent>
            </Select>
            <p v-if="errors.career" class="text-xs text-destructive mt-1">
              {{ errors.career }}
            </p>
          </div>
        </div>
      </div>

      <DialogFooter>
        <DialogClose as-child class="w-full sm:w-auto">
          <Button variant="outline" class="w-full sm:w-auto">Cancelar</Button>
        </DialogClose>
        <Button
          @click="handleSubmit"
          class="w-full sm:w-auto"
          :disabled="isLoading"
        >
          {{ isLoading ? "Guardando..." : "Crear estudiante" }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
