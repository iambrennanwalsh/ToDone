<template>
	<div>
		<div class='columns wrapem'>
			<div v-for="(list, index) in lists" class='list column box is-6'>
				<button @click="triggerDelModal(list, index)" class="delete is-pulled-right"></button>
				<span @click="triggerEditModal(list, index)" class="fa fa-edit editbutton is-pulled-right"></span>
				<p class="is-size-4 m-bottom-10"><a v-text='list.name' class='has-text-info' :href="'https://todone.local/list/' + list.id"></a></p>
				<p class="m-bottom-20 has-text-dark" v-text="list.description"></p>
				<p class="m-bottom-10">
					<span class="tag is-primary m-right-10"><span v-text="list.completed"></span>/<span v-text="list.total"></span> Completed</span>
				</p>
				<progress class="progress is-primary" :value="Number.isNaN(list.completed / list.total) ? 0 : (list.completed / list.total) * 100" max="100">{{ Number.isNaN(list.completed / list.total) ? 0 : (list.completed / list.total) * 100}}</progress>
			</div>
		</div>
		<transition name="fade">
			<modal v-on:confirm="deletelist" v-on:closemodal="closemodal" v-show="showDelModal" closebutton>
				<span slot="title">Delete list</span>
				<span slot="content">Are you absolutely sure you'd like to delete this list? It cannot be recovered!</span>
				<span slot="confirm">Delete List</span>
				<span slot="close">Nevermind</span>
			</modal>
		</transition>
		<transition name="fade">
			<modal v-on:confirm="addlist" v-on:closemodal="closemodal" v-show="showAddModal" closebutton v-bind:loadin="loadin">
				<span slot="title">Create a new list</span>
				<div slot="content">
					Choose a name for your new list and then write a description of it.
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
				<span slot="confirm">Create List</span>
				<span slot="close">Nevermind</span>
			</modal>
		</transition>
		<transition name='fade'>
			<modal v-on:confirm="editlist" v-on:closemodal="closemodal" v-show="showEditModal" closebutton v-bind:loadin="loadin">
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

	export default {
		components: {
			'modal': Modal
		},

		data: function() {
			return {
				lists: '',
				showDelModal: false,
				showAddModal: false,
				showEditModal: false,
				activeList: '',
				title: '',
				description: '',
				attempted: '',
				loadin: false
			}
		},

		computed: {
			titleStatus: function() {
				return this.title === ''
			},
			descStatus: function() {
				return this.description === ''
			}
		},

		methods: {

			deletelist: function() {
				axios.post('/api/modlist', {
					do: 'delete',
					list: this.activeList[0]
				}).then(this.$delete(this.lists, this.activeList[1]));
				let link = document.querySelector('#sidelists li[data-listid="' + this.activeList[0].id + '"]');
				link.outerHTML = '';
				this.closemodal();
			},

			addlist: function() {
				this.attempted = true;
				if (this.titleStatus !== true) {
					axios.post('/api/modlist', {
						do: 'add',
						title: this.title,
						desc: this.description
					}).then(response => {
						this.lists.push(response.data);
						this.closemodal();
						this.loadin = false;
						this.attempted = false;
						document.querySelector('#sidelists').innerHTML += "<li data-listid='" + response.data.id + "'><a href='/list/" + response.data.id + "'>" + response.data.name + "</a></li>";
					});
					this.loadin = true;
				}
			},

			editlist: function() {
				this.attempted = true;
				if (this.titleStatus !== true) {
					axios.post('/api/modlist', {
						do: 'edit',
						title: this.title,
						desc: this.description,
						list: this.activeList[0].id
					}).then(response => {
						this.activeList[0].name = this.title;
						this.activeList[0].description = this.description;
						let link = document.querySelector('#sidelists li[data-listid="' + this.activeList[0].id + '"]');
						link.firstChild.textContent = this.title;
						this.closemodal();
						this.loadin = false;
						this.attempted = false;
					});
					this.loadin = true;
				}
			},

			triggerEditModal(list, index) {
				this.showEditModal = true;
				this.activeList = [list, index];
				this.title = list.name;
				this.description = list.description;
			},

			triggerDelModal(list, index) {
				this.showDelModal = true;
				this.activeList = [list, index];
			},

			triggerAddModal() {
				this.showAddModal = true;
			},

			closemodal() {
				this.showDelModal = false;
				this.showAddModal = false;
				this.showEditModal = false;
				this.activeList = '';
				this.title = '';
				this.description = '';
			}
		},

		created: function() {
			axios.get('/api/getlist', {
				params: {
					do: 'lists'
				}
			}).then(response => {
				this.lists = response.data;
			});
		}

	}

</script>
