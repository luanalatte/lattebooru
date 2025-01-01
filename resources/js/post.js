document.addEventListener("alpine:init", () => {
  Alpine.data("visibilitySelect", (submitUrl) => ({
    submit() {
      return axios
        .post(submitUrl, {
          visibility: this.visibility.id,
        })
        .then((response) => {
          this.visibility = response.data.visibility;
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
  }));
});
