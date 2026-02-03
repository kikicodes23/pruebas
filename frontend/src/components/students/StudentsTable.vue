<script setup lang="ts">
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/common/table";
import Pagination from "@/components/common/Pagination.vue";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/common/dropdown-menu";
import Button from "@/components/common/Button.vue";
import Skeleton from "@/components/common/skeleton/Skeleton.vue";
import { MoreHorizontal, Eye, Pencil, Trash, UserX } from "lucide-vue-next";

import type { Student } from "@/interfaces/Student";

interface Props {
  data: Student[];
  page: number;
  totalPages: number;
  limit?: number;
  loading?: boolean;
  selectable?: boolean;
}

defineProps<Props>();
const emit = defineEmits([
  "update:page",
  "update:limit",
  "view",
  "edit",
  "delete",
  "select",
]);

const onPageChange = (page: number) => {
  emit("update:page", page);
};

const onLimitChange = (limit: number) => {
  emit("update:limit", limit);
};
</script>

<template>
  <div class="w-full">
    <div class="rounded-md border bg-card overflow-x-auto">
      <Table>
        <TableCaption v-if="!loading && data.length === 0">
          <div
            class="flex flex-col items-center justify-center py-12 text-center"
          >
            <div class="rounded-full bg-muted p-4 mb-4">
              <UserX class="h-10 w-10 text-muted-foreground" />
            </div>
            <h3 class="text-xl font-semibold">No hay estudiantes</h3>
            <p class="text-muted-foreground mt-2 max-w-sm">
              No se encontraron estudiantes registrados en el sistema.
            </p>
          </div>
        </TableCaption>
        <TableHeader>
          <TableRow class="bg-muted/50 hover:bg-muted/50 border-none">
            <TableHead class="text-center font-bold text-foreground"
              >Carnet</TableHead
            >
            <TableHead class="font-bold text-foreground">Nombre</TableHead>
            <TableHead class="font-bold text-foreground">Apellido</TableHead>
            <TableHead class="font-bold text-foreground">Email</TableHead>
            <TableHead class="font-bold text-foreground">Carrera</TableHead>
            <TableHead class="w-12.5"></TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <template v-if="loading">
            <TableRow v-for="i in 5" :key="i">
              <TableCell class="text-center"
                ><Skeleton class="h-4 w-20 mx-auto"
              /></TableCell>
              <TableCell><Skeleton class="h-4 w-32" /></TableCell>
              <TableCell><Skeleton class="h-4 w-32" /></TableCell>
              <TableCell><Skeleton class="h-4 w-48" /></TableCell>
              <TableCell><Skeleton class="h-4 w-40" /></TableCell>
              <TableCell><Skeleton class="h-8 w-8 rounded-full" /></TableCell>
            </TableRow>
          </template>
          <template v-else>
            <TableRow
              v-for="student in data"
              :key="student.id"
              class="hover:bg-muted/30 odd:bg-white even:bg-white border-b"
            >
              <TableCell class="text-center font-medium">{{
                student.carnet
              }}</TableCell>
              <TableCell>{{ student.name }}</TableCell>
              <TableCell>{{ student.lastname }}</TableCell>
              <TableCell>{{ student.email }}</TableCell>
              <TableCell>{{ student.career }}</TableCell>
              <TableCell>
                <div v-if="selectable">
                  <Button
                    size="sm"
                    @click="emit('select', student)"
                    class="bg-primary text-primary-foreground hover:bg-primary/90"
                  >
                    Seleccionar
                  </Button>
                </div>
                <DropdownMenu v-else>
                  <DropdownMenuTrigger as-child>
                    <Button
                      variant="ghost"
                      size="icon"
                      class="h-8 w-8 text-foreground"
                    >
                      <span class="sr-only">Open menu</span>
                      <MoreHorizontal :size="16" />
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent align="end">
                    <DropdownMenuLabel>Acciones</DropdownMenuLabel>
                    <DropdownMenuItem
                      @click="
                        $router.push(`/students/${student.id}/academic-record`)
                      "
                    >
                      <Eye class="mr-2 h-4 w-4" />
                      Reporte de notas
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="emit('edit', student)">
                      <Pencil class="mr-2 h-4 w-4" />
                      Editar
                    </DropdownMenuItem>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem
                      @click="emit('delete', student)"
                      class="group hover:text-destructive hover:bg-destructive/10"
                    >
                      <Trash
                        class="mr-2 h-4 w-4 group-hover:text-destructive"
                      />
                      Eliminar
                    </DropdownMenuItem>
                  </DropdownMenuContent>
                </DropdownMenu>
              </TableCell>
            </TableRow>
          </template>
        </TableBody>
      </Table>
    </div>

    <Pagination
      :page="page"
      :total-pages="totalPages"
      :limit="limit"
      @update:page="onPageChange"
      @update:limit="onLimitChange"
    />
  </div>
</template>
