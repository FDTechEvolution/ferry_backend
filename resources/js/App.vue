<template>
    <div id="wrapper" class="d-flex align-items-stretch flex-column">
        <layout-header />
        <!-- content -->
        <div id="wrapper_content" class="d-flex flex-fill">
            <layout-sidebar />

            <!-- main -->
            <main id="middle" class="flex-fill mx-auto">
                <layout-pagetitle />

                <router-view />
            </main>
        </div>
        <layout-footer />
    </div>
</template>

<style scoped>
    body.layout-admin #middle.mx-auto {
        min-height: 85vh;
    }
</style>