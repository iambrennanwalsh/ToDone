<template>
	<div class='columns'>
		<ul id="list" class='list-group column is-6 m-top-20'>
			<draggable v-model="tasks" @change="sort">
				<transition-group name='fade'>
				<li v-for="(task, index) in tasks" :key="index" :data-index='index' v-bind:class="{greenit: task.status != 0}" class=' task has-text-dark'>
  			<label v-on:click="toggleTask">
					<span v-bind:class="{'fa-check': task.status != 0}" class="check fa m-left-0"></span>
					<span v-bind:class="{underline: task.status != 0}" class="taskname m-left-20" v-text='task.name'></span>
				</label>
				<span v-on:click="deleteTask" class='delete is-pulled-right'></span>
			</li>  	
	</transition-group>
			</draggable>
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
			<transition name='fade'>
			<modal v-on:confirm="editlist" v-on:closemodal="closemodal" v-show="showEditModal" closebutton v-bind:loadin="loader">
				<span slot="title">Edit list</span>
				<div slot="content">
					Change the name and description of your list.
					<div class="m-top-20 field is-horizontal">
						<div class="field-label is-normal">
							<label class="label has-text-dark">List Title</label>
						</div>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<input v-model="title" :class="{'is-primary': attempted && titleStatus}" class="input" type="text" name="title" placeholder="e.g. Meeting Times..">
								</div>
							</div>
						</div>
					</div>
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label has-text-dark">List Description</label>
						</div>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<textarea v-model='description' class="textarea" name="message" placeholder="What's this list all about?"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<span slot="confirm">Edit List</span>
				<span slot="close">Nevermind</span>
			</modal>
		</transition>
	</div>
</template>

<script>
import Modal from './modal.vue';
import draggable from 'vuedraggable';

export default {
	
	components: {
			'modal': Modal,
			'draggable': draggable},
	
	data: function() {
		return {
			list: '',
			tasks: [],
			newtask: '',
			loader: false,
			showEditModal: false,
			title: '',
			description: '',
			attempted: false,
		}
		
	},
	
	computed: {
		titleStatus: function() {
			return this.title === ''
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
			event.target.parentElement.outerHTML = '';
			axios.post('/api/modtask', {do: 'delete',  task: event.target.parentElement.dataset.index, list: this.list.id});},
		
		addTask: function(event) {
			if (this.newtask == '') {}//nope
			else {
			axios.post('/api/modtask', {do: 'add',  task: this.newtask, list: this.list.id}).then(response => {
				this.loader = false;
				this.tasks.push(response.data);
				this.newtask = '';});
			this.loader = true;}},
		
		editlist: function() {
			this.attempted = true;
			if (this.titleStatus !== true) {
				axios.post('/api/modlist', {
					do: 'edit',
					title: this.title,
					desc: this.description,
					list: this.list.id,
				}).then(response => {
					this.list.name = this.title;
					this.list.description = this.description;
					document.querySelector('#listtitle').textContent = this.title;
					document.querySelector('#listsub').textContent = this.description;
					let link = document.querySelector('#sidelists li[data-listid="' + this.list.id + '"]');
					link.firstChild.textContent = this.title;
					this.closemodal();
				});
				this.loader = true;}
			},
		
		closemodal: function() {
			this.showEditModal = false;
			this.loader = false;
			this.attempted = false;
			this.title = '';
			this.description = '';
		},
		
		triggerEditModal() {
			this.showEditModal = true;
			this.title = this.list.name;
			this.description = this.list.description;},
		
		sort: function() {
			axios.post('/api/modtask', {do: 'sort',  new: this.tasks, list: this.list.id});}
	},
	
	created: function() {
		let url = window.location.pathname;
		url = url.split('/');
		url = url.pop();
		if(isNaN(url) == false) {
			axios.get('/api/getlist', {params: {do: 'list', list: url}}).then(response => {
				this.list = response.data[0];
				this.tasks = response.data[0]['tasklist'];
			});
		}
	}
	
}

</script>