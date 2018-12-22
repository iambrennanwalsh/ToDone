<template>
	<div class='columns'>
		<ul id="list" class='column is-6 m-top-20'>
			<li v-for="(task, index) in tasks" :data-index='index' v-bind:class="{greenit: task[1] != 0}" class='has-text-dark'>
				<label v-on:click="toggleTask">
					<span v-bind:class="{'fa-check': task[1] != 0}" class="check fa m-left-0"></span>
					<span v-bind:class="{underline: task[1] != 0}" class="taskname m-left-20" v-text='task[0]'></span>
				</label>
				<span v-on:click="deleteTask" class='delete is-pulled-right'></span>
			</li>
			<form v-on:submit.prevent="addTask" id="addtask" method='post' class="column">
				<div class="field has-addons">
					<div class="control w-100">
    				<input v-model="newtask" class="input" name="task" type="text" placeholder="Go to grocery store..">
					</div>
					<div class="control">
						<button type='submit' v-on:submit.prevent="addTask" :class='{"is-loading": loader}' class="button is-info">
							<span class='fa fa-plus'></span>
						</button>
					</div>
				</div>
			</form>
			</ul> 
	</div>
</template>

<script>
	
export default {
	
	data: function() {
		return {
			list: '',
			tasks: [],
			newtask: '',
			loader: false
		}
		
	},
	
	methods: {
		
		toggleTask: function(event) {
			if (event.target.firstChild.classList.contains('fa-check')) {
				event.target.firstChild.classList.remove('fa-check');
				event.target.firstChild.nextElementSibling.classList.remove('underline');
				event.target.parentElement.classList.remove('greenit');
				axios.post('/api/modtask', {do: 'check',  change: 0, task: event.target.parentElement.dataset.index, list: this.list.id});}
			else {
				event.target.firstChild.classList.add('fa-check');
				event.target.firstChild.nextElementSibling.classList.add('underline');
				event.target.parentElement.classList.add('greenit');
				axios.post('/api/modtask', {do: 'check', change: 1, task: event.target.parentElement.dataset.index, list: this.list.id});}},
		
		deleteTask: function(event) {
			this.$delete(this.tasks, event.target.parentElement.dataset.index);
			axios.post('/api/modtask', {do: 'delete',  task: event.target.parentElement.dataset.index, list: this.list.id});},
		
		addTask: function(event) {
			axios.post('/api/modtask', {do: 'add',  task: this.newtask, list: this.list.id}).then(response => {
				this.loader = false;
				this.tasks.push(response.data);
				this.newtask = '';});
			this.loader = true;}
		
	},
	
	created: function() {
		let url = window.location.pathname;
		url = url.split('/');
		url = url.pop();
		if(isNaN(url) == false) {
			axios.get('/api/getlist', {params: {do: 'list', list: url}}).then(response => {
				this.list = response.data[0];
				let temp = this.list.tasks.split(' - ');
				if (temp != '') {
					let fina = new Array();
					temp.forEach(function(vari) {
						fina.push(vari.split(' => '));
					});
					this.tasks = fina;}
			});
		}
	}
	
}

</script>