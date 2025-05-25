
<template>
  <div class="ms-auto">
    <div class="btn-group">
      <button type="button" class="btn btn-outline-primary">
        <Translate text="Options" />
      </button>
      <button type="button"
              class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
              data-bs-toggle="dropdown">
                      <span class="visually-hidden">
                        <Translate text="Toggle Dropdown" />
                      </span>
      </button>
      <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">

        <NuxtLink class="dropdown-item"  v-for="(op,i) in options.filter(x=>x&&x.path)" :to="op.path" >
          <Translate :text="op.label" />
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:["options"],
}
</script>
<style scoped>

</style>