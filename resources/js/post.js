document.addEventListener("alpine:init", () => {
  Alpine.data("visibilitySelect", (submitUrl) => ({
    submit() {
      return axios
        .post(submitUrl, {
          visibility: this.visibility.id,
        })
        .then((response) => {
          this.visibility = response.data.visibility;
          this.$store.toast.addToast("Visibility changed to " + this.visibility.name);
        })
        .catch((error) => {
          this.$store.toast.addToast(error.response?.data?.message ?? error.message, "error");
        });
    },
  }));
});
