window.tagEditorData = (updateTagsUrl) => {
  return {
    edit: false,
    message: null,
    tag: "",
    tempTags: {},
    init() {
      this.edit = false;
      this.tempTags = Object.fromEntries(Object.keys(this.tags).map((tag) => [tag, 1]));
    },
    sanitizeTag(tag) {
      return new String(tag).trim().toLowerCase().replace(/\s+/g, " ");
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
    submitTags() {
      return axios
        .post(updateTagsUrl, {
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
  };
};
