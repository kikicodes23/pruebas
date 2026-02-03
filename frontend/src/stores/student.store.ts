import { defineStore } from "pinia";
import { ref } from "vue";
import { StudentService } from "@/services/student.service";
import type { Student } from "@/interfaces/Student";
import type { PaginatedData } from "@/interfaces/ApiResponse";

export const useStudentStore = defineStore("student", () => {
  const students = ref<Student[]>([]);
  const loading = ref(false);
  const error = ref<string | null>(null);
  const pagination = ref<PaginatedData<Student> | null>(null);

  const fetchStudents = async (page = 1, perPage = 10, search = "") => {
    loading.value = true;
    error.value = null;
    try {
      const data = await StudentService.getAll(page, perPage, search);
      students.value = data.data.data;
      pagination.value = data.data;
    } catch (err: any) {
      console.error("Error fetching students:", err);
      // Let component handle specific validation errors if needed, or set generic error here
      error.value = err.message || "Failed to fetch students";
    } finally {
      loading.value = false;
    }
  };

  const createStudent = async (student: Omit<Student, "id">) => {
    error.value = null;
    try {
      await StudentService.create(student);
      // We rely on the component to refetch to preserve search/pagination state
    } catch (err: any) {
      console.error("Error creating student:", err);
      error.value = err.message || "Failed to create student";
      throw err; // Re-throw to handle in component
    }
  };

  const updateStudent = async (id: number, student: Omit<Student, "id">) => {
    error.value = null;
    try {
      await StudentService.update(id, student);
    } catch (err: any) {
      console.error("Error updating student:", err);
      error.value = err.message || "Failed to update student";
      throw err;
    }
  };

  const deleteStudent = async (id: number) => {
    error.value = null;
    try {
      await StudentService.delete(id);
    } catch (err: any) {
      console.error("Error deleting student:", err);
      error.value = err.message || "Failed to delete student";
      throw err;
    }
  };

  return {
    students,
    loading,
    error,
    pagination,
    fetchStudents,
    createStudent,
    updateStudent,
    deleteStudent,
  };
});
