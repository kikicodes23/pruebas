import api from "./api";

export interface Subject {
  id: number;
  name: string;
  code: number;
  uv: number;
  created_at: string;
  updated_at: string;
}

export interface SubjectsResponse {
  message: string;
  data: Subject[];
}

export const subjectService = {
  getAll: async (): Promise<Subject[]> => {
    const response = await api.get<SubjectsResponse>("/subjects");
    return response.data.data;
  },
};
