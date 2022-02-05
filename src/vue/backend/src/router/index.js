import Vue from 'vue'
import VueRouter from 'vue-router'
import Generic from '@/templates/layout/Generic'
import Layout from '@/templates/layout/Layout'
import routeMeta from './routeMeta'

Vue.use(VueRouter)

const routes = [
    {
        path: '',
        component: () => import('@/views/children/redirectPage')
    },
    {
        path: '',
        component: Layout,
        children: [
            {
                path: '/import',
                name: 'Import',
                component: Generic,
                children: [
                    {
                        path: 'listings',
                        component: () => import('@/views/import/Listings'),
                        children: routeMeta.imports.listings,
                        props: {
                            parentRoute: '/import/listings',
                            tabbedRoutes: routeMeta.imports.listings
                        }
                    },
                    {
                        path: 'agents',
                        component: () => import('@/views/import/Agents'),
                        children: routeMeta.imports.agents,
                        props: {
                            parentRoute: '/import/agents',
                            tabbedRoutes: routeMeta.imports.agents
                        }
                    }
                ]
            },
            {
                path: '/settings',
                name: 'Settings',
                component: Generic,
                children: [
                    {
                        path: 'general',
                        name: 'IMPress General Settings',
                        component: () => import('@/views/settings/General')
                    },
                    {
                        path: 'omnibar',
                        name: 'IMPress Omnibar Settings',
                        component: () => import('@/views/settings/Omnibar')
                    },
                    {
                        path: 'listings',
                        component: () => import('@/views/settings/Listings'),
                        children: routeMeta.settings.listings,
                        props: {
                            parentRoute: '/settings/listings',
                            tabbedRoutes: routeMeta.settings.listings
                        }
                    },
                    {
                        path: 'agents',
                        name: 'IMPress Agents Settings',
                        component: () => import('@/views/settings/Agents')
                    },
                    {
                        path: 'social-pro',
                        name: 'Social Pro Settings',
                        component: () => import('@/views/settings/SocialPro')
                    },
                    {
                        path: 'gmb',
                        name: 'Google My Business',
                        component: () => import('@/views/settings/GMB')
                    }
                ]
            },
            {
                path: '/guided-setup',
                name: 'Guided Setup',
                component: Generic,
                children: [
                    {
                        path: 'welcome',
                        name: 'Welcome',
                        component: () => import('@/views/guided-setup/Welcome')
                    },
                    {
                        path: 'connect/api',
                        name: 'Connect Account',
                        component: () => import('@/views/guided-setup/Api')
                    },
                    {
                        path: 'connect/general',
                        name: 'General Settings',
                        component: () => import('@/views/guided-setup/General')
                    },
                    {
                        path: 'connect/omnibar',
                        name: 'Omnibar Settings',
                        component: () => import('@/views/guided-setup/Omnibar')
                    },
                    {
                        path: 'listings',
                        name: 'Activate IMPress Listings',
                        component: () => import('@/views/guided-setup/Listings')
                    },
                    {
                        path: 'listings/general',
                        name: 'Configure General IMPress Listings',
                        component: () => import('@/views/guided-setup/ListingsGeneral')
                    },
                    {
                        path: 'listings/idx',
                        name: 'Configure IDX IMPress Listings',
                        component: () => import('@/views/guided-setup/ListingsIdx')
                    },
                    {
                        path: 'listings/advanced',
                        name: 'Configure Advanced IMPress Listings',
                        component: () => import('@/views/guided-setup/ListingsAdvanced')
                    },
                    {
                        path: 'agents',
                        name: 'Activate IMPress Agents',
                        component: () => import('@/views/guided-setup/Agents')
                    },
                    {
                        path: 'agents/configure',
                        name: 'Configure IMPress Agents',
                        component: () => import('@/views/guided-setup/AgentsConfigure')
                    },
                    {
                        path: 'social-pro',
                        name: 'Activate Social Pro',
                        component: () => import('@/views/guided-setup/SocialPro')
                    },
                    {
                        path: 'social-pro/configure',
                        name: 'Configure Social Pro',
                        component: () => import('@/views/guided-setup/SocialProConfigure')
                    },
                    {
                        path: 'confirmation',
                        name: 'Confirmation',
                        component: () => import('@/views/guided-setup/Confirmation')
                    }
                ]
            },
            {
                path: '/*',
                name: '404',
                component: () => import('@/views/404')
            }
        ]
    }
]

const router = new VueRouter({
    routes
})

router.afterEach((to, from) => {
    window.scrollTo({
        top: 0,
        left: 0
    })
})
export default router
