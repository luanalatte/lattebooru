document.addEventListener("alpine:init", () => {
  Alpine.data("commentBox", (submitUrl) => ({
    text: '',
    submit() {
        return axios
          .post(submitUrl, {
            comment: this.text,
          })
          .then((response) => {
            this.text = '';
            this.comments.push(response.data.comment);
          })
          .catch((error) => {
            this.$store.toast.addToast(error.response?.data?.message ?? error.message, "error");
          });
      },
  }));
});
