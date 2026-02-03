export interface Subject {
  id: number;
  name: string;
  code: number;
  uv: number;
  created_at: string;
  updated_at: string;
}

export interface Semester {
  id: number;
  year: number;
  semester_number: number;
  created_at: string;
  updated_at: string;
}

export interface StudentRegister {
  id: number;
  student_id: number;
  subject_id: number;
  semester_id: number;
  grade: number;
  created_at: string;
  updated_at: string;
  subject: Subject;
  semester: Semester;
}
