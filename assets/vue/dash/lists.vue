<template>
<div>
	<div v-for="(list, index) in listsObj" class='list column box is-6'>
			<button @click="$root.$emit('init-modal', activeList = [list.id, index])" class="delete is-pulled-right"></button>
			<p class="is-size-3"><a v-text='list.name' :href="'https://bizplan.local/list/' + list.id"></a></p>
			<p class="m-bottom-10 has-text-dark" v-text="list.description"></p>
			<p class="m-bottom-10">
				<span class="tag is-info m-right-10"><span v-text="list.completed"></span>/<span v-text="list.total"></span> Completed</span>
				<span class="tag is-dark m-right-10">Created: <span v-text="list.created"></span></span>
			</p>
			<progress class="progress is-primary" :value="(list.completed / list.total) * 100" max="100">{{ (list.completed / list.total) * 100}}</progress>
		</div>
	</div>
</template>


<script>
	export default {
		props: {
			listsObj: '',
		}, 
		methods: {
			deleteList(activeList) {
					axios.post('/deletelist', {id: activeList[0]}).then(this.$delete(this.$root.listsObj, activeList[1]));},
		//	addList(data) {
		//			axios.post('/addlist', {data: data}).then(function(response) {this.$root.listsObj.push({response});})}
		},
		created: function() {
			this.$root.$on('delete-list', activeList => {
        this.deleteList(activeList);
				this.$root.$emit('close-modal');
    });
		//this.$root.$on('add-list', data => {
    //    this.addList(data);
		//		this.$root.$emit('close-modal');
    //});
	
	}
	}
</script>