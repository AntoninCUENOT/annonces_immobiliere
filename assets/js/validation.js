document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const inputs = form.querySelectorAll("input");
            let allFilled = true;

            inputs.forEach((input) => {
                if (input.value.trim() === "") {
                    allFilled = false;
                    input.style.borderColor = "red";
                } else {
                    input.style.borderColor = "";
                }
            });

            if (!allFilled) {
                alert("Veuillez remplir tous les champs.");
            } else {
                form.submit();
            }
        });
    });
});
