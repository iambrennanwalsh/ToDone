<template>
	<div class='columns'>
		<ul id="list" class='list-group column is-6 m-top-20'>
			<draggable v-model="changed" @change="sort">
				<transition-group name='fade'>
					<li v-for="(item, index) in task" :key="index" :data-index='index' v-bind:class="{greenit: item.status != 0}" class=' task has-text-dark'>
						<label v-on:click="toggleTask">
							<span v-bind:class="{'fa-check': item.status != 0}" class="check fa m-left-0"></span>
							<span v-bind:class="{underline: item.status != 0}" class="taskname m-left-20" v-text='item.name'></span>
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
			'draggable': draggable
		},

		data: function() {
			return {
				userid: '',
				list: '',
				task: [],
				newtask: '',
				nextpos: 0,
				title: '',
				description: '',
				loader: false,
				showEditModal: false,
				attempted: false,
				changed: ''
			}
		},

		props: {
			listid: String
		},

		computed: {
			titleStatus: function() {
				return this.list.title === ''
			}
		},

		methods: {

			toggleTask: function(event) {
				let index = event.target.parentElement.dataset.index;
				console.log(index);
				if (this.tasks[index].status == 0) {
					this.tasks[index].status = 1;
					axios.post('/api/modtask', {
						do: 'check',
						change: 1,
						task: index,
						list: this.list.id
					});
				} else {
					this.tasks[index].status = 0;
					axios.post('/api/modtask', {
						do: 'check',
						change: 0,
						task: index,
						list: this.list.id
					});
				}
			},

			deleteTask: function(event) {
				this.tasks.splice(event.target.parentElement.dataset.index, 1);
				axios.post('/api/modtask', {
					do: 'delete',
					task: event.target.parentElement.dataset.index,
					list: this.list.id
				});
			},

			addTask: function(event) {
				if (this.newtask == '') {} //nope
				else {
				this.list.tasks.forEach(function(element) {
					let arr = 0;
					if (element.position > arr) {
						this.nextpos = element.position;
					}
				});
					axios.post('/api/tasks', {
						listsid: "/api/lists/" + this.listid,
						name: this.newtask,
						status: 0,
						position: this.list.tasks.length
					}).then(response => {
						this.loader = false;
						this.task.push({
							name: this.newtask,
							status: 0
						});
						this.newtask = '';
					});
					this.loader = true;
				}
			},
			editlist: function() {
				this.attempted = true;
				if (this.titleStatus !== true) {
					axios.put('/api/lists/' + this.list.id, {
						name: this.title,
						description: this.description,
						modified: new Date()
					}).then(response => {
						this.list.name = this.title;
						this.list.description = this.description;
						let link = document.querySelector('#sidelists li[data-listid="' + this.list.id + '"]');
						let tit = document.getElementById('listtitle');
						let des = document.getElementById('listsub');
						link.firstChild.textContent = this.title;
						tit.textContent = this.title;
						des.textContent = this.description;
						this.closemodal();
						this.loader = false;
						this.attempted = false;
					});
					this.loader = true;
				}
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
				this.description = this.list.description;
			},

			sort: function(event) {
				let location = event.target.parentElement.dataset.index;
				axios.put('/api/tasks' + this.task[location], {
					name: this.task[location].name,
					status: this.task[location].status,
					position: location
				});
			}
		},
		
		created: function() {
			let temp = [];
			axios.get('/api/users')
				.then(response => {
					this.userid = response.data[0].id;
				});
			axios.get('/api/lists/' + this.listid)
				.then(response => {
					this.list = response.data;
					this.list.tasks.forEach(function(el) {
						axios.get(el)
							.then(response => {
								temp.push(response.data);
						}); 
					});
					this.task = temp;
				});	
			}
		}


</script>
