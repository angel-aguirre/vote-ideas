<x-modal-confirm
    eventToOpenModal="custom-show-mark-comment-as-not-spam-modal"
    eventToCloseModal="commentWasMarkedAsNotSpam"
    title="Reset Comment Spam Counter"
    description="Are you sure you want to mark this comment as NOT spam? This will reset the spam counter to 0."
    confirmButtonText="Reset Spam Counter"
    wireClick="markCommentAsNotSpam"
/>