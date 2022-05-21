const mp = new MercadoPago('TEST-c95303fa-246f-4452-bde3-f128ca706a6c');
//const mp = new MercadoPago('APP_USR-76ebbf7d-27e9-4139-8fa9-a9ddba08deb0');
const cardForm = mp.cardForm({
    amount: document.getElementById('total_carrinho').value,
    autoMount: true,
    
    form: {
        id: "form-checkout",
        cardholderName: {id: "form-checkout__cardholderName", placeholder: "Titular do cartão", },
        cardholderEmail: {id: "form-checkout__cardholderEmail", placeholder: "E-mail", },
        cardNumber: {id: "form-checkout__cardNumber", placeholder: "Número do cartão", },
        cardExpirationDate: {id: "form-checkout__cardExpirationDate", placeholder: "Data de vencimento (MM/YYYY)", },
        securityCode: {id: "form-checkout__securityCode", placeholder: "Código de segurança", },
        installments: {id: "form-checkout__installments", placeholder: "Parcelas", },
        identificationType: {id: "form-checkout__identificationType", placeholder: "Tipo de documento", },
        identificationNumber: {id: "form-checkout__identificationNumber", placeholder: "Número do documento", },
        issuer: {id: "form-checkout__issuer", placeholder: "Banco emissor", },
    },
    callbacks: {
        onFormMounted: error => {
            if (error) {
                return console.log("Form Mounted handling error: ", error);
            }
            console.log("Form mounted");
        },
        onSubmit: event => {
            event.preventDefault();
            const {
                paymentMethodId: payment_method_id,
                issuerId: issuer_id,
                cardholderEmail: email,
                amount,
                token,
                installments,
                identificationNumber,
                identificationType,
            } = cardForm.getCardFormData();

            fetch("/api/mp/pagamentocc", {
                method: "POST",
                headers: {"Content-Type": "application/json", },
                body: JSON.stringify({
                    token,
                    issuer_id,
                    payment_method_id,
                    transaction_amount: Number(amount),
                    installments: Number(installments),
                    description: "Compra instinto intimo",
                    payer: {
                        email,
                        identification: {
                            type: identificationType,
                            number: identificationNumber,
                        },
                    },
                }),
            })
                    .then(response => {
                        return response.json();
                    })
                    .then(result => {
                        console.log(result)
                        if (!result.hasOwnProperty("error_message")) {
//                            window.location.href = '/meuspedidos';
                        } else {
                            document.getElementById("container__payment").innerText = result.error_message;
                            document.getElementById("error-message").textContent = result.error_message;
                            document.getElementById("fail-response").style.display = "block";
                        }

                    })
                    .catch(error => {
                        console.log(error);
                        location.reload();
//                        alert("Erro ao efetuar p pagamento");
                    });

        },
        onFetching: (resource) => {
            console.log("Fetching resource: ", resource);

            // Animate progress bar
            const progressBar = document.querySelector(".progress-bar");
            progressBar.removeAttribute("value");

            return () => {
                progressBar.setAttribute("value", "0");
            };
        }
    },
});