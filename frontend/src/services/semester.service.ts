import api from "./api";

export interface Semester {
  id: number;
  year: number;
  semester_number: number;
  created_at: string;
  updated_at: string;
}

export interface SemestersResponse {
  message: string;
  data: Semester[];
}

export const semesterService = {
  getAll: async (): Promise<Semester[]> => {
    const response = await api.get<SemestersResponse>("/semesters");
    return response.data.data;
  },
};
