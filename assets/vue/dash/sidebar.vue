<template>
	<ul id='sidelists' class="menu-list">
		<li v-for="board in $root.boards" :data-listid="board.id">
			<a :class="{'is-active':(active == board.id)}" :href="'/list/' + board.id" class=''>
				{{ board.name }}
			</a>
		</li>
	</ul>
</template>

<script>

	export default {
	
		props: {
			active: String
		},
		
	}

</script>