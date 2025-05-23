<script setup>
import Task from "@/components/tasks/Task.vue";

defineProps({
    tasks:Array,
    show: {
        type:Boolean,
        default:true
    }

})
</script>


<template>
    <div class="card mt-2" v-if="tasks.length && show" >
        <ul class="list-group list-group-flush">
            <task v-for="task in tasks" :key="task.id" :task="task" />
        </ul>
    </div>
</template>
