function updateFingerprint(fingerprint)
{
  if(fingerprint == null)
  {
    return;
  }
  part = document.getElementById("fingerprint");
  part.value = fingerprint;
  document.getElementById("submitButton").disabled = false;
}

fingerpinrt = null;
console.log("starting")
// Initialize the agent at application startup.
const fpPromise = import('https://fpcdn.io/v3/dCePoiiehsErH9JIzs9T')
  .then(FingerprintJS => FingerprintJS.load());

// Get the visitor identifier when you need it.
fpPromise
  .then(fp => fp.get())
  .then(result => updateFingerprint(result.visitorId));
