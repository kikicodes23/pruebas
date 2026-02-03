export interface PaginationLink {
  url: string | null;
  label: string;
  active: boolean;
  page?: number | null;
}

export interface PaginatedData<T> {
  current_page: number;
  data: T[];
  first_page_url: string;
  from: number | null;
  last_page: number;
  last_page_url: string;
  links: PaginationLink[];
  next_page_url: string | null;
  path: string;
  per_page: number;
  prev_page_url: string | null;
  to: number | null;
  total: number;
}

export interface ApiResponse<T> {
  message: string;
  data: PaginatedData<T>;
}

export interface SingleApiResponse<T> {
  message: string;
  data: T;
}

export interface ValidationErrorResponse {
  message: string;
  errors: Record<string, string[]>;
}
