<template>
    <layout-pagetitle title="Users" subtitle="จัดการผู้ใช้งาน" />
    <h1>Users</h1>

    <data-table :thead="_thead" :tbody="_tbody" />

    
</template>

<script setup>
    const _thead = ['ชื่อ', 'อายุ', 'ตำแหน่ง', 'สถานที่']
    const _tbody = [
        {
            name: 'nauthiz',
            age: '35',
            position: 'PHP DEV',
            office: 'Chiang mai'
        },
        {
            name: 'nauthiz',
            age: '35',
            position: 'PHP DEV',
            office: 'Chiang mai'
        },
        {
            name: 'nauthiz',
            age: '35',
            position: 'PHP DEV',
            office: 'Chiang mai'
        }
    ]
</script>