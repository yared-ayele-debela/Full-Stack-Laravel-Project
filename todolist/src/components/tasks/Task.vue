<script setup>

import {computed,ref} from "vue";
import TaskActions from "@/components/tasks/TaskActions.vue";

const props= defineProps({
    task:Object
})

const completedClass= computed(()=> props.task.is_completed ? "completed":"")

const isEdit = ref(false);
const editingTask= ref(props.task.name);

const vFocus = {
    mounted: (el) =>el.focus
}

const emit = defineEmits(['updated','completed','removed'])

const updateTask = event =>{
    const  updatedTask = { ...props.task, name:event.target.value}
    isEdit.value=false
    emit('updated',updatedTask);
}

const markTaskAsCompleted = event =>{
    const  updatedTask = { ...props.task, is_completed:!props.task.is_completed}
    emit('completed',updatedTask);
}
const undo =()=>{
    isEdit.value=false
    editingTask.value=props.task.name
}

const removeTask = () =>{
    if(confirm("Are you sure to delete this task?")){
        emit('removed',props.task)
    }
}

</script>

<template>
    <li class="list-group-item py-3">
        <div class="d-flex justify-content-start align-items-center">
            <input class="form-check-input mt-0"
                   type="checkbox"
                   :class="completedClass"
                   :checked="task.is_completed"
                   @change="markTaskAsCompleted"
            />
            <div class="ms-2 flex-grow-1" :class="completedClass" @dblclick="$event=>isEdit=true" title="Double click the text to edit or remove">
                <div class="relative" v-if="isEdit">
                    <input class="editable-task" type="text" v-focus  @keyup.esc="undo" @keyup.enter="updateTask" v-model="editingTask" />
                </div>
                <span v-else>{{task.name}}</span>
            </div>
            <div class="task-date">{{task.created_at}}</div>
        </div>
        <div class="task-actions">
          <TaskActions
              @edit="$event=>isEdit=true"
              v-show="!isEdit"
              @remove="removeTask"
          />
        </div>
    </li>
</template>
