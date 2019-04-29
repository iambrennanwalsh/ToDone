<template>
	<div>
		<div class='columns'>
			<div class='column'>
				<button @click="open('create')" class="button is-primary is-inverted is-pulled-right"><span class="fa fa-plus m-left-0"></span> Add Board</button>
				<h1 class='title has-text-grey-dark'>Boards</h1>
			</div>
		</div>
		<div class='columns wrapem'>
			<div v-for="(board, index) in $root.boards" class='board column box is-6'>
				<button @click="open('delete', board, index)" class="delete is-pulled-right"></button>
				<span @click="open('edit', board, index)" class="fa fa-edit editbutton is-pulled-right"></span>
				<p class="is-size-4 m-bottom-10"><a v-text='board.name' class='has-text-info' :href="'/board/' + board.id"></a></p>
				<p class="m-bottom-20 has-text-dark" v-text="board.description"></p>
				<p class="m-bottom-10">
					<span class="tag is-primary m-right-10"><span v-text="board.completed"></span>/<span v-text="board.total"></span> Completed</span>
				</p>
				<progress class="progress is-primary" :value="Number.isNaN(board.completed / board.total) ? 0 : (board.completed / board.total) * 100" max="100">{{ Number.isNaN(board.completed / board.total) ? 0 : (board.completed / board.total) * 100}}</progress>
			</div>
		</div>
		<modal ref="create" title="Create a new board." closebutton confirmbutton confirmtext="Create Board" validate>
			<div slot="content">
				Choose a name for your new board and then write a description of it.
				<div class="m-top-20 field is-horizontal">
					<div class="field-label is-normal">
						<label class="label has-text-dark">Board Title</label>
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
						<label class="label has-text-dark">Board Description</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<textarea v-model="desc" class="textarea" name="message" placeholder="What's this board all about?"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</modal>
		<modal ref="delete" title="Delete Board" confirmbutton closebutton confirmtext="Delete Board">
			<span slot="content">
				Are you absolutely sure you'd like to delete this board? It cannot be recovered!
			</span>
		</modal>
		<modal ref="edit" title="Edit Board" confirmbutton closebutton confirmtext="Edit Board" validate>
			<div slot="content">
				Change the name and description of your board.
				<div class="m-top-20 field is-horizontal">
					<div class="field-label is-normal">
						<label class="label has-text-dark">Board Title</label>
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
						<label class="label has-text-dark">Board Description</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<textarea v-model='desc' class="textarea" name="message" placeholder="What's this board all about?"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</modal>
	</div>
</template>

<script>
	import Modal from './modal';

	export default {

		components: {
			'modal': Modal
		},

		data() {
			return {
				show: true,
				activeboard: "",
				activeindex: "",
				activeaction: "",
				title: "",
				desc: "",
				attempted: false
			}
		},

		computed: {
			titleStatus: function() {
				return this.title === ''
			}
		},

		methods: {

			open(action = "", board = "", index = "") {
				this.activeaction = action;
				this.activeboard = board;
				this.activeindex = index;
				if (action == "create") this.$refs.create.open();
				if (action == "delete") this.$refs.delete.open();
				if (action == "edit") {
					this.title = board.name;
					this.desc = board.description;
					this.$refs.edit.open();
				}
			},

			confirm() {
				if (this.activeaction == "delete") this.delete();
				if (this.activeaction == "create") this.create();
				if (this.activeaction == "edit") this.edit();
			},

			clear() {
				this.attempted = false;
				this.title = "";
				this.desc = "";
				this.activeboard = "";
				this.activeindex = "";
				this.activeaction = "";
			},

			delete() {
				axios.delete('/api/boards/' + this.activeboard.id)
					.then(response => {
						this.$delete(this.$root.boards, this.activeindex);
						this.$refs.delete.close();
					});
			},

			create() {
				axios.post('/api/boards', {
					name: this.title,
					description: this.desc,
					created: new Date(),
					modified: new Date(),
					total: 0,
					completed: 0,
					userid: "/api/users/" + this.$root.user[0].id
				}).then(response => {
					this.$root.boards.push(response.data);
					this.$refs.create.close();
				});
			},

			edit() {
				axios.put('/api/boards/' + this.activeboard.id, {
					name: this.title,
					description: this.desc,
					modified: new Date()
				}).then(response => {
					console.log(this.activeindex);
					this.$root.boards.splice(this.activeindex, 1, response.data);
					this.$refs.edit.close();
				});
			}

		}

	}

</script>
