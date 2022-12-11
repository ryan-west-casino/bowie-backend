window.addEventListener("message", function(event) {
console.log("event found in listen!", event)
});

window.addEventListener("balance_updated", function(event) {
console.log("event found in listen!", event)
});