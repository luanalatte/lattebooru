<div x-data="$store.toast" class="fixed">
  <template x-teleport="body">
    <div class="fixed bottom-0 right-0 mx-8">
      <template x-for="(toast, id) in toasts" x-bind:key="id">
        <div class="mb-4 w-80 rounded-md border bg-white p-4 shadow-md data-[type=error]:border-red-500"
             x-bind:data-type="toast.type" x-on:click="removeToast(id)">
          <div class="gap- flex items-center justify-between">
            <span x-text="toast.message"></span>
            <x-icon name="mdi:close"/>
          </div>
        </div>
      </template>
    </div>
  </template>
</div>
