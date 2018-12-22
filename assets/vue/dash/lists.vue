<template>
	<div>
		<div class='columns wrapem'>
			<div v-for="(list, index) in lists" class='list column box is-6'>
				<button @click="triggerDelModal(list, index)" class="delete is-pulled-right"></button>
				<p class="is-size-3"><a v-text='list.name' class='has-text-primary' :href="'https://bizplan.local/list/' + list.id"></a></p>
				<p class="m-bottom-10 has-text-dark" v-text="list.description"></p>
				<p class="m-bottom-10">
					<span class="tag is-info m-right-10"><span v-text="list.completed"></span>/<span v-text="list.total"></span> Completed</span>
					<span class="tag is-dark m-right-10">Created: <span v-text="list.created"></span></span>
				</p>
				<progress class="progress is-primary" :value="Number.isNaN(list.completed / list.total) ? 0 : (list.completed / list.total) * 100" max="100">{{ Number.isNaN(list.completed / list.total) ? 0 : (list.completed / list.total) * 100}}</progress>
			</div>
		</div>
		<transition name="fade">
			<modal v-on:del-modal="deletelist" v-on:close-modal="closemodal" v-show="showDel" close-it delete-it>
				<span slot="title">Delete list</span>
				<span slot="content">Are you absolutely sure you'd like to delete this list? It cannot be recovered!</span>
				<span slot="delete">Delete List</span>
				<span slot="close">Nevermind</span>
			</modal>
		</transition>
		<transition name="fade">
			<modal v-on:add-modal="addlist" :loadin="loadin" v-on:close-modal="closemodal" v-show="showAdd" close-it add-it>
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
				<span slot="add">Create List</span>
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
				showDel: false,
				showAdd: false,
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
				this.closemodal();},

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
						this.title = '';
						this.description = '';
					});
					this.loadin = true;
				}
			},

			triggerDelModal(list, index) {
				this.showDel = true;
				this.activeList = [list, index];
			},

			triggerAddModal() {
				this.showAdd = true;
			},

			closemodal() {
				this.showDel = false;
				this.showAdd = false;
				this.activeList = '';
			}
		},

		created: function() {
			axios.get('/api/getlist', {params: {do: 'lists'}}).then(response => {
				this.lists = response.data;
			});
		}

	}

</script>
