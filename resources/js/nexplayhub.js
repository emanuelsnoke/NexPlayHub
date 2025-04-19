window.toggleProfileMenu = function () {
    document.getElementById("profileMenu").classList.toggle("show");
};

window.addPost = async function () {
    const file = document.getElementById("postFile").files[0];
    const text = document.getElementById("postText").value.trim();

    if (!text && !file) {
        alert("Escreva algo ou envie um arquivo.");
        return;
    }

    const formData = new FormData();
    formData.append("content", text);
    formData.append("_token", document.querySelector('meta[name="csrf-token"]').content);
    if (file) formData.append("image", file);

    try {
        const response = await fetch("/posts", {
            method: "POST",
            body: formData,
            credentials: "same-origin"
        });

        if (response.redirected) {
            window.location.href = response.url;
            return;
        }

        if (!response.ok) throw new Error("Erro ao criar post.");

        const data = await response.json();
        renderPost(data.post, true);

        document.getElementById("postText").value = "";
        document.getElementById("postFile").value = "";
    } catch (error) {
        console.error("Erro:", error);
        alert("Erro ao criar post.");
    }
};

function renderPost(post, isOwner = false) {
    const postEl = document.createElement("div");
    postEl.className = "post";

    const author = document.createElement("div");
    author.className = "post-author";
    author.textContent = post.user?.name ?? "Usuário";
    postEl.appendChild(author);

    if (post.image_path) {
        const img = document.createElement("img");
        img.src = `/storage/${post.image_path}`;
        postEl.appendChild(img);
    }

    if (post.content) {
        const textEl = document.createElement("div");
        textEl.className = "post-text";
        textEl.textContent = post.content;
        postEl.appendChild(textEl);
    }

    const actions = document.createElement("div");
    actions.className = "actions";

    let likes = 0;
    const likeBtn = document.createElement("button");
    likeBtn.textContent = "Curtir (0)";
    likeBtn.onclick = () => {
        likes++;
        likeBtn.textContent = `Curtir (${likes})`;
    };

    const shareBtn = document.createElement("button");
    shareBtn.textContent = "Compartilhar";
    shareBtn.onclick = () => alert("Compartilhado com sucesso!");

    actions.append(likeBtn, shareBtn);

    if (isOwner || post.is_owner) {
        const editBtn = document.createElement("button");
        editBtn.textContent = "Editar";
        editBtn.onclick = () => {
            const newText = prompt("Edite seu post:", post.content);
            if (newText !== null) {
                postEl.querySelector(".post-text").textContent = newText;
            }
        };

        const delBtn = document.createElement("button");
        delBtn.textContent = "Excluir";
        delBtn.onclick = async () => {
            if (confirm("Deseja excluir este post?")) {
                const resp = await fetch(`/posts/${post.id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: "same-origin"
                });

                if (resp.ok) postEl.remove();
                else alert("Erro ao excluir post.");
            }
        };

        actions.append(editBtn, delBtn);
    }

    postEl.appendChild(actions);

    const commentSection = document.createElement("div");
    commentSection.className = "comments";

    const commentList = document.createElement("div");
    commentSection.appendChild(commentList);

    const commentInputWrapper = document.createElement("div");
    commentInputWrapper.className = "comment-input";

    const commentInput = document.createElement("input");
    commentInput.type = "text";
    commentInput.placeholder = "Escreva um comentário...";

    const sendBtn = document.createElement("button");
    sendBtn.innerHTML = "➤";
    sendBtn.onclick = () => {
        if (commentInput.value.trim()) {
            const comment = document.createElement("div");
            comment.className = "comment";
            comment.textContent = commentInput.value;
            commentList.appendChild(comment);
            commentInput.value = "";
        }
    };

    commentInputWrapper.append(commentInput, sendBtn);
    commentSection.append(commentInputWrapper);
    postEl.appendChild(commentSection);

    document.getElementById("postsContainer").prepend(postEl);
}

// ✅ Carrega posts ao entrar na dashboard
window.addEventListener("DOMContentLoaded", async () => {
    try {
        const response = await fetch("/posts", {
            headers: {
                "Accept": "application/json"
            },
            credentials: "same-origin"
        });

        if (!response.ok) throw new Error("Erro ao carregar posts.");

        const data = await response.json();
        data.posts.forEach(post => renderPost(post, post.is_owner));
    } catch (err) {
        console.error(err);
        alert("Erro ao carregar os posts.");
    }
});
