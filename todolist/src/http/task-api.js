import api from "@/http/api.js";

const resource = "/tasks";

export  const allTasks = ()=> api.get(resource);

export  const createTask = task =>api.post(resource,task);

export  const updateTask= (id, task) =>api.put(`${resource}/${id}`,task);

export  const removeTask= id =>api.delete(`${resource}/${id}`);

export  const completeTask = (id, task) =>api.post(`${resource}/${id}/complete`,task);
