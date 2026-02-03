import api from "./api";
import type { Student } from "@/interfaces/Student";
import type { ApiResponse, SingleApiResponse } from "@/interfaces/ApiResponse";
import type { StudentRegister } from "@/interfaces/AcademicRecord";

export const StudentService = {
  async getAll(page = 1, perPage = 10, search = "") {
    const params: any = { page, per_page: perPage };
    if (search) {
      params.search = search;
    }
    const response = await api.get<ApiResponse<Student>>("/students", {
      params,
    });
    return response.data;
  },

  async create(student: Omit<Student, "id">) {
    const response = await api.post<SingleApiResponse<Student>>(
      "/students",
      student,
    );
    return response.data;
  },

  async getById(id: number) {
    const response = await api.get<SingleApiResponse<Student>>(
      `/students/${id}`,
    );
    return response.data;
  },

  async update(id: number, student: Omit<Student, "id">) {
    const response = await api.patch<SingleApiResponse<Student>>(
      `/students/${id}`,
      student,
    );
    return response.data;
  },

  async delete(id: number) {
    const response = await api.delete<SingleApiResponse<null>>(
      `/students/${id}`,
    );
    return response.data;
  },

  async getRegisters(id: number | string) {
    const response = await api.get<SingleApiResponse<StudentRegister[]>>(
      `/registers/${id}`,
    );
    return response.data;
  },

  async getTranscript(id: number | string) {
    const response = await api.get(`/students/${id}/transcript/view`, {
      responseType: "blob",
    });
    return response.data;
  },

  async sendTranscriptEmail(id: number | string) {
    const response = await api.get(`/students/${id}/transcript/email`);
    return response.data;
  },
};
