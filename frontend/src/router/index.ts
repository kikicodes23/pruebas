import { createRouter, createWebHistory } from "vue-router";
import { ROUTES } from "@/constants/routes";

import StudentsView from "@/views/StudentsView.vue";
import RegistersView from "@/views/RegistersView.vue";
import AcademicRecordView from "@/views/AcademicRecordView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: ROUTES.HOME,
      name: "home",
      component: StudentsView,
    },
    {
      path: ROUTES.STUDENTS,
      name: "events",
      component: StudentsView,
    },
    {
      path: ROUTES.GRADES,
      name: "activities",
      component: RegistersView,
    },
    {
      path: "/students/:id/academic-record",
      name: "academic-record",
      component: AcademicRecordView,
    },
  ],
});

export default router;
