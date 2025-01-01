document.addEventListener("alpine:init", () => {
  Alpine.data("tagEditor", (submitUrl) => ({
    edit: false,
    message: null,
    tempTags: {},
    init() {
      this.edit = false;
      this.tempTags = Object.fromEntries(this.tags.map((tag) => [tag.name, 1]));
    },
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
    cancelEditing() {
      this.init();
    },
    submitTags() {
      return axios
        .post(submitUrl, {
          tags: this.tempTags,
        })
        .then((response) => {
          this.tags = response.data.tags;
          this.init();
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
  }));
});
