<template>
    <header>
        <h1 class="h4">{{ props.title }}</h1>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item text-muted active" aria-current="page">{{ props.subtitle }}</li>
        </ol>
        </nav>
    </header>
</template>

<script setup>
    const props = defineProps(['title', 'subtitle'])
</script>