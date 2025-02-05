document.addEventListener("alpine:init", () => {
  Alpine.data("tagEditor", (submitUrl) => ({
    edit: false,
    message: null,
    tempTags: {},
    tags: [],
    sanitizeTag(tag) {
      return new String(tag).trim().toLowerCase().replace(/\s/g, "_").replace(/--+/g, "-").replace(/__+/g, "_");
    },
    addTag(tag) {
      if (!this.edit) return;

      tag = this.sanitizeTag(tag);
      if (tag === "") return;

      if (tag.startsWith("-")) {
        this.tempTags[tag.substring(1)] = 0;
      } else {
        this.tempTags[tag] = 1;
      }
    },
    removeTag(tag) {
      if (!this.edit) return;

      tag = this.sanitizeTag(tag);
      if (tag === "") return;

      this.tempTags[tag] = 0;
    },
    startEditing() {
      this.edit = true;
      this.tempTags = Object.fromEntries(this.tags.map((tag) => [tag.name, 1]));
      this.$refs.taginput.focus();
    },
    cancelEditing() {
      this.edit = false;
      this.tempTags = {};
    },
    submitTags() {
      return axios
        .post(submitUrl, {
          tags: this.tempTags,
        })
        .then((response) => {
          this.tags = response.data.tags;
          this.cancelEditing();
        })
        .catch((error) => {
          this.$store.toast.addToast(error.response?.data?.message ?? error.message, "error");
        });
    },
  }));
});
