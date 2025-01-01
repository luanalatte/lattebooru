import "./bootstrap";

document.addEventListener("alpine:init", function () {
  Alpine.store("toast", {
    toasts: {},
    addToast(message, type = "success") {
      const id = Date.now();
      this.toasts[id] = { message, type };

      setTimeout(() => {
        this.removeToast(id);
      }, 5000);
    },
    removeToast(id) {
      delete this.toasts[id];
    },
  });
});
