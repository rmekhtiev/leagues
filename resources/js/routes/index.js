import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "index",
    },
    {
        path: "/leagues",
        name: "leagues",
        component: () => import("@/pages/leagues/index"),
    },
    {
        path: "/leagues/:id",
        name: "leagueId",
        component: () => import("@/pages/leagues/id"),
        children: [
            {
                path: "",
                name: "leagueHome",
                component: () => import("@/pages/leagues/LeagueHome"),
            },
        ],
    },
    {
        path: "/403",
        name: "forbidden",
        component: () => import("@/pages/exceptions/Forbidden"),
    },
    {
        path: "/404",
        name: "not-found",
        component: () => import("@/pages/exceptions/NotFound"),
    },
    {
        path: "*",
        component: () => import("@/pages/exceptions/NotFound"),
    },
];

const router = new VueRouter({
    mode: "history",
    routes,
});

export default router;
