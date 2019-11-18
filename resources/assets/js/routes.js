import Home from './components/Home.vue';
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';

import ContactMain from './components/contacts/Main.vue';
import ContactList from './components/contacts/List.vue';
import Contact from './components/contacts/View.vue';

export const routes = [
	{
		path: '/',
		component: Home,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/home',
		component: Home,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/login',
        component: Login
	},
	{
		path: '/register',
        component: Register
	},
	{
		path: '/contact',
		component: ContactMain,
		meta: {
			requiresAuth: true
		},
		children: [
			 {
                path: '/',
                component: ContactList
            },
            {
                path: ':id',
                component: Contact
            }
		]
	}
]