<script setup lang="ts">
import { ref } from "vue";
import { useStudentStore } from "@/stores/student.store";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogClose,
} from "@/components/common/dialog";
import Button from "@/components/common/Button.vue";
import Alert from "@/components/common/Alert.vue";

const props = defineProps<{
  studentId: number | null;
  open: boolean;
}>();

const emit = defineEmits(["update:open", "refresh"]);

const studentStore = useStudentStore();
const isLoading = ref(false);
const successMessage = ref("");
const errorMessage = ref("");

const handleDelete = async () => {
  if (!props.studentId) return;

  isLoading.value = true;
  try {
    successMessage.value = "";
    errorMessage.value = "";
    await studentStore.deleteStudent(props.studentId);
    successMessage.value = "Estudiante eliminado exitosamente";
    emit("refresh");
    setTimeout(() => {
      emit("update:open", false);
      successMessage.value = "";
    }, 1500);
  } catch (error) {
    console.error("Failed to delete", error);
    errorMessage.value = "Error al eliminar el estudiante";
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <Dialog :open="open" @update:open="emit('update:open', $event)">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Eliminar Estudiante</DialogTitle>
        <DialogDescription>
          ¿Estás seguro de que deseas eliminar este estudiante? Esta acción no
          se puede deshacer.
        </DialogDescription>
      </DialogHeader>

      <div class="py-2">
        <Alert v-if="successMessage" variant="success" class="mb-4">
          {{ successMessage }}
        </Alert>
        <Alert v-if="errorMessage" variant="error" class="mb-4">
          {{ errorMessage }}
        </Alert>
      </div>

      <DialogFooter>
        <DialogClose as-child class="w-full sm:w-auto">
          <Button variant="outline" class="w-full sm:w-auto">Cancelar</Button>
        </DialogClose>
        <Button
          @click="handleDelete"
          class="w-full sm:w-auto bg-destructive text-destructive-foreground hover:bg-destructive/90"
          :disabled="isLoading"
        >
          {{ isLoading ? "Eliminando..." : "Eliminar" }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
