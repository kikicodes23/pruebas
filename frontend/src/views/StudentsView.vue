<script setup lang="ts">
import { onMounted, computed, watch, ref } from "vue";
import { storeToRefs } from "pinia";
import { useRoute, useRouter } from "vue-router";
import PageLayout from "@/layouts/PageLayout.vue";
import StudentsTable from "@/components/students/StudentsTable.vue";
import CreateStudentModal from "@/components/students/CreateStudentModal.vue";
import EditStudentModal from "@/components/students/EditStudentModal.vue";
import DeleteStudentModal from "@/components/students/DeleteStudentModal.vue";
import { useStudentStore } from "@/stores/student.store";
import type { Student } from "@/interfaces/Student";
import { Search } from "lucide-vue-next";

const route = useRoute();
const router = useRouter();
const studentStore = useStudentStore();
const { students, pagination, loading } = storeToRefs(studentStore);

const editModalOpen = ref(false);
const deleteModalOpen = ref(false);
const selectedStudentId = ref<number | null>(null);
const search = ref("");
const debouncedSearch = ref("");

const fetchParams = () => {
  const page = Number(route.query.page) || 1;
  const perPage = Number(route.query.per_page) || 10;
  const searchParam = (route.query.search as string) || "";
  return { page, perPage, search: searchParam };
};

onMounted(() => {
  const { page, perPage, search: searchParam } = fetchParams();
  search.value = searchParam;
  debouncedSearch.value = searchParam;
  studentStore.fetchStudents(page, perPage, searchParam);
});

watch(
  () => route.query,
  () => {
    const { page, perPage, search: searchParam } = fetchParams();
    if (search.value !== searchParam) {
      search.value = searchParam;
    }
    studentStore.fetchStudents(page, perPage, searchParam);
  },
);

let debounceTimeout: ReturnType<typeof setTimeout>;

const onSearchInput = (event: Event) => {
  const target = event.target as HTMLInputElement;
  search.value = target.value;

  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(() => {
    debouncedSearch.value = search.value;
    updateQuery(1, limit.value, search.value);
  }, 500);
};

const page = computed(() => pagination.value?.current_page || 1);
const totalPages = computed(() => pagination.value?.last_page || 1);
const limit = computed(() => pagination.value?.per_page || 10);

const updateQuery = (newPage: number, newLimit: number, newSearch?: string) => {
  const query: any = {
    ...route.query,
    page: newPage.toString(),
    per_page: newLimit.toString(),
  };

  if (newSearch !== undefined) {
    if (newSearch) {
      query.search = newSearch;
    } else {
      delete query.search;
    }
  }

  router.push({ query });
};

const handlePageChange = (newPage: number) => {
  updateQuery(newPage, limit.value, search.value);
};

const handleLimitChange = (newLimit: number) => {
  updateQuery(1, newLimit, search.value);
};

const handleView = (student: Student) => {
  console.log("Viewing student", student);
};

const handleEdit = (student: Student) => {
  selectedStudentId.value = student.id;
  editModalOpen.value = true;
};

const handleDelete = (student: Student) => {
  selectedStudentId.value = student.id;
  deleteModalOpen.value = true;
};

const handleCreateStudent = async (student: Omit<Student, "id">) => {
  try {
    await studentStore.createStudent(student);
    // Refresh list keeping current params
    const { page, perPage, search } = fetchParams();
    await studentStore.fetchStudents(page, perPage, search);
  } catch (error) {
    console.error("Failed to create student", error);
    // Handle error (e.g. show toast)
  }
};
</script>

<template>
  <PageLayout title="Estudiantes">
    <template #actions>
      <div
        class="flex flex-col items-stretch sm:flex-row sm:items-center gap-2 w-full sm:w-auto"
      >
        <div class="relative w-full sm:w-auto">
          <Search
            class="absolute left-2 top-2.5 h-4 w-4 text-muted-foreground"
          />
          <input
            :value="search"
            @input="onSearchInput"
            placeholder="Buscar por nombre, apellido o carnet..."
            class="pl-8 h-10 w-full sm:w-[300px] rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
          />
        </div>
        <CreateStudentModal
          @submit="handleCreateStudent"
          trigger-class="w-full sm:w-auto h-10"
        />
      </div>
      <EditStudentModal
        v-model:open="editModalOpen"
        :student-id="selectedStudentId"
        @refresh="
          () => {
            const { page, perPage, search } = fetchParams();
            studentStore.fetchStudents(page, perPage, search);
          }
        "
      />
      <DeleteStudentModal
        v-model:open="deleteModalOpen"
        :student-id="selectedStudentId"
        @refresh="
          () => {
            const { page, perPage, search } = fetchParams();
            studentStore.fetchStudents(page, perPage, search);
          }
        "
      />
    </template>

    <div class="w-full">
      <StudentsTable
        :data="students"
        :page="page"
        :total-pages="totalPages"
        :limit="limit"
        :loading="loading"
        @update:page="handlePageChange"
        @update:limit="handleLimitChange"
        @view="handleView"
        @edit="handleEdit"
        @delete="handleDelete"
      />
    </div>
  </PageLayout>
</template>
