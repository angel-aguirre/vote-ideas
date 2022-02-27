<x-modal-confirm
    eventToOpenModal="custom-show-delete-comment-modal"
    eventToCloseModal="commentWasDeleted"
    title="Delete Comment"
    description="Are you sure you want to delete this comment? This action cannot be undone."
    confirmButtonText="Delete"
    wireClick="deleteComment"
/>