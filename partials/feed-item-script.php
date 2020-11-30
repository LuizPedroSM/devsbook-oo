<script>
    window.onload = async function () {
        document.querySelectorAll(".like-btn").forEach(item => {
            item.addEventListener("click", async () => {
                let id = item.closest(".feed-item").getAttribute("data-id");
                let count = parseInt(item.innerText);
                if (item.classList.contains("on") === false) {
                    item.classList.add("on");
                    item.innerText = ++count;
                } else {
                    item.classList.remove("on");
                    item.innerText = --count;
                }

                await fetch("ajax_like.php?id=" + id);
            });
        });
    }
</script>