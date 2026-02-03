import api from "./api";

export interface CreateRegisterData {
  student_id: number;
  subject_id: number;
  semester_id: number;
  grade: number;
}

export const registerService = {
  create: async (data: CreateRegisterData) => {
    const response = await api.post("/registers", data);
    return response.data;
  },
};
