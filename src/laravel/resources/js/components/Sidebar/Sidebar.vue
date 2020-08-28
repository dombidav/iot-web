<template>
    <sidebar-menu :menu="menu">
        <div slot="header">header</div>
        <div slot="footer">footer</div>
        <span slot="toggle-icon"><i class="fas fa-arrow-alt-right"/></span>
        <span slot="dropdown-icon"><i class="fas fa-caret-down"/></span>
    </sidebar-menu>
</template>

<script>
    /**
     * @link https://github.com/yaminncco/vue-sidebar-menu
     */
    export default {
        data() {
            return {
                menu: [
                    {
                        header: true,
                        title: 'Main Navigation',
                        hiddenOnCollapse: true
                    },
                    {
                        href: '/',
                        title: 'Dashboard',
                        icon: {
                            element: 'i',
                            class: 'fas fa-tachometer-alt'
                        }
                    },
                    {
                        href: '/user',
                        title: 'User Management',
                        icon: {
                            element: 'i',
                            class: 'fas fa-user'
                        }
                    },
                    {
                        href: '#',
                        title: 'Access Control',
                        icon: '',
                        child: [
                            {
                                href: '/acs/worker',
                                title: 'Workers',
                                icon: {
                                    element: 'i',
                                    class: 'fas fa-user'
                                }
                            },
                            {
                                href: '/acs/lock',
                                title: 'Locks',
                                icon: {
                                    element: 'i',
                                    class: 'fas fa-lock'
                                }
                            },
                            {
                                href: '/acs/group',
                                title: 'Groups',
                                icon: {
                                    element: 'i',
                                    class: 'fas fa-group'
                                }
                            },
                            {
                                href: '/acs/log',
                                title: 'Access Log',
                                icon: {
                                    element: 'i',
                                    class: 'fas fa-list'
                                }
                            },
                        ]
                    }
                ]
            }
        },
    }
</script>
