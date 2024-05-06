// @ts-nocheck
import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import firstPage from "./components/pages/firstPage";
import secondPage from "./components/pages/secondPage";

//project pages....

//import mainApp from './components/mainApp'
import home from "./components/pages/home";
import tags from "./admin/pages/tags";
import adminusers from "./admin/pages/adminusers";
import categories from "./admin/pages/categories";
import comA from "./components/basic/comA";
import login from "./admin/pages/login";
import roles from "./admin/pages/roles";
import assignRole from "./admin/pages/assignRole";
import blogs from "./admin/pages/blogs";
import createBlog from "./admin/pages/createBlog";
import editBlog from "./admin/pages/editBlog";
import notfound from "./admin/pages/notfound";

const routes = [
    //project routes....

    {
        path: "/",
        component: home,
        name: "/"
    },
    {
        path: "/tags",
        component: tags,
        name: "tags"
    },
    {
        path: "/categories",
        component: categories,
        name: "categories"
    },
    {
        path: "/blogs",
        component: blogs,
        name: "blogs"
    },
    {
        path: "/createBlog",
        component: createBlog,
        name: "createBlog"
    },
    {
        path: "/editBlog/:id",
        component: editBlog,
        name: "editBlog"
    },
    {
        path: "/admin",
        component: adminusers,
        name: "admin"
    },
    {
        path: "/login",
        component: login,
        name: "login"
    },
    {
        path: "/roles",
        component: roles,
        name: "roles"
    },
    {
        path: "/assignRole",
        component: assignRole,
        name: "assignRole"
    },
    {
        path: "/*",
        component: notfound,
        name: "notfound"
    },







    ///basic tutorial routes
    {
        path: "/test_vuex",
        component: comA
    },
    {
        path: "/new-vue-route",
        component: firstPage
    },
    {
        path: "/new-second-vue-route",
        component: secondPage
    }
];

export default new Router({
    mode: "history",
    base: `/`,
    routes,
    fallback: true,
});
