// Ajax за изтриване на събитие
$(document).on("click", ".delete-ajax", function () {
    let button = $(this);
    let id = button.data("id"); // ID на събитието

    // Потвърждение за изтриване
    if (!confirm("Сигурни ли сте, че искате да изтриете това събитие?")) {
        return;
    }

    // Изпращане на Ajax заявка
    $.ajax({
        url: "delete_event_ajax.php",
        type: "POST",
        data: { id: id },
        success: function (response) {
            if (response === "success") {
                button.closest("tr").remove(); // Премахване на реда от таблицата
                alert("Събитието е изтрито успешно!");
            } else {
                alert("Грешка: " + response);
            }
        },
        error: function () {
            alert("Възникна проблем със заявката.");
        },
    });
});
// Ajax за зареждане на редакция на събитие
$(document).on("click", ".edit-ajax", function () {
    let id = $(this).data("id"); // ID на събитието

    // Зареждане на формата за редакция
    $.ajax({
        url: "edit_event_ajax.php",
        type: "GET",
        data: { id: id },
        success: function (response) {
            $("#edit-container").html(response); // Зарежда формата в контейнера
        },
        error: function () {
            alert("Възникна проблем със заявката.");
        },
    });
});
// Ajax за запазване на редактирано събитие
$(document).on("click", "#save-changes", function () {
    let formData = $("#edit-form").serialize(); // Събира всички данни от формата

    $.ajax({
        url: "update_event_ajax.php",
        type: "POST",
        data: formData,
        success: function (response) {
            if (response === "success") {
                alert("Събитието е актуализирано успешно!");
                location.reload(); // Презарежда таблицата
            } else {
                alert("Грешка: " + response);
            }
        },
        error: function () {
            alert("Възникна проблем със заявката.");
        },
    });
});
// Показване на модалния прозорец за редакция
$(document).on("click", ".edit-ajax", function () {
    let id = $(this).data("id"); // ID на събитието

    // Изпращане на Ajax заявка за зареждане на формата
    $.ajax({
        url: "edit_event_ajax.php",
        type: "GET",
        data: { id: id },
        success: function (response) {
            $("#modal-body").html(response); // Зареждане на формата в модалното тяло
            $("#edit-modal").fadeIn(); // Показване на модалния прозорец
        },
        error: function () {
            alert("Възникна проблем със зареждането на формата.");
        },
    });
});

// Затваряне на модалния прозорец
$(document).on("click", ".close", function () {
    $("#edit-modal").fadeOut(); // Скриване на модалния прозорец
});

// Ajax за филтриране
$("#filter-form").on("submit", function (e) {
    e.preventDefault(); // Спри стандартното изпращане на формата

    let form = $(this);
    let filter = $("#filter").val(); // Вземи стойността на полето

    $.ajax({
        url: "filter_events_ajax.php",
        type: "GET",
        data: { filter: filter },
        success: function (response) {
            $("#events-table").html(response); // Обнови таблицата
        },
        error: function () {
            alert("Възникна проблем със заявката.");
        },
    });
});
