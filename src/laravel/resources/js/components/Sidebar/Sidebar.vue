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
                        href: '/charts',
                        title: 'Charts',
                        icon: '',
                        child: [
                            {
                                href: '/charts/sublink',
                                title: 'Sub Link'
                            }
                        ]
                    }
                ]
            }
        },
    }
</script>
