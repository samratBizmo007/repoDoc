<h1 id="static_pages">Static Pages</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>myPatientSignoutNotes.json</h4>
							</div>
							<!-- REQUEST RESPONSE FORMAT -->
							<div class="highlight boderleft">
								<h4 class="colorblue">Supported Formats</h4>  
								<code class="colorblue">JSON</code>
								<code class="colorblue">XML</code>
								<br><br>
								<p class="colorred">*Default Response is in JSON</p>
							</div>

							<!-- REQUEST METHOD -->
							<h3 id="type21">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input21">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYWdlX2lkIjoxfQ.hStUjkmJmeoypGvaHsVGAR07X7moGbltJ3a1xkAkpY8
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output21">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjp7InRpdGxlIjoiQWJvdXQgVXMiLCJjb250ZW50IjoiRGFpbHkgRG9jIFRlY2hub2xvZ2llcyBMTEMgd2FzIGNvbmNlaXZlZCB0byBpbm5vdmF0ZSBhbmQgYnJpbmcgY3V0dGluZyBlZGdlIHRlY2hub2xvZ3kgaW4gbWVkaWNpbmUuICBPdXIgbWlzc2lvbiBpcyB0byBtYWtlIHBhdGllbnQgY2FyZSBtb3JlIGVmZmljaWVudCwgZWZmb3J0bGVzcyBhbmQgbWluaW1pemUgbWVkaWNhbCBlcnJvcnMuIFdlIGZvY3VzIG9uIGJyaW5naW5nIHVzZWZ1bCBJVCBzb2x1dGlvbnMgaW4gbWVkaWNpbmUuPGJyPjxicj5XaXRoIGFkdmFuY2VtZW50cyBpbiB0ZWNobm9sb2d5LCBjb21tdW5pY2F0aW9uIGluIGhlYWx0aGNhcmUgY2FuIGJlIG1hZGUgc2VhbWxlc3MgYW5kIGVmZm9ydGxlc3MuICBMYWNrIG9mIGVmZmVjdGl2ZSBjb21tdW5pY2F0aW9uIGlzIG9uZSBvZiB0aGUgbWFpbiBjYXVzZXMgb2YgbWVkaWNhbCBlcnJvcnMgYW5kIHVud2FudGVkIG91dGNvbWVzLiBEYWlseSBEb2MgSGVhbHRoY2FyZSBBcHAgYnJpbmdzIHRoZSB0ZWNobm9sb2d5IGluIHRvZGF5XHUyMDE5cyBjb21wbGV4IG1lZGljYWwgZW52aXJvbm1lbnQgdG8gZ2l2ZSBoZWFsdGhjYXJlIHByb3ZpZGVycyB0b29scyBuZWVkZWQgdG8gaGF2ZSBlZmZvcnRsZXNzLCByZWxpYWJsZSBhbmQgc2VjdXJlIGNvbW11bmljYXRpb24uICBEZXNpZ25lZCBieSBkb2N0b3JzIGFuZCBudXJzZXMsIHdlIHN0cml2ZSB0byBtYWtlIG91ciBwbGF0Zm9ybSBiZXR0ZXIgZXZlcnkgZGF5LiAgSG9uZXN0eSBhbmQgSW50ZWdyaXR5IGFyZSBvdXIgY29yZSB2YWx1ZXMuICBXZSBzdHJpdmUgdG8gaW5ub3ZhdGUgaW4gaGVhbHRoY2FyZSB0byBicmluZyBhYm91dCBwb3NpdGl2ZSBtZWFuaW5nZnVsIGNoYW5nZXMgaW4gcGVvcGxlcyBsaXZlcy4ifX0.IEtNal3YYOVBohsiNVr5_goFOlW4xK-fb3ETuahQ3l4"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6IkludmFsaWQgaGVhZGVyIHBhc3NlZC4ifQ.Y4Jeb0RFe89kh4-G4rD7HWG_kbAcET5o4uFE8W9-_ZA"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMSwibWVzc2FnZSI6IllvdSBhcmUgdW5hdXRob3JpemVkIHRvIGFjY2VzcyB0aGlzIGxvY2F0aW9uLiJ9.As058aErTIv1Jbqnj4w5MdMzTvshS411w7ZoHc3Te_M"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6Ik9vcHMgISBTb21ldGhpbmcgd2VudCB3cm9uZy4ifQ.Wb-KLc0jy7_FDdXCK0NsbXNSxU0kgw7fBgjRRk4jUSE"
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>