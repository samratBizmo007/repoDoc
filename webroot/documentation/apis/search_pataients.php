<h1 id="search_pataients">Search Pataients</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>findPataients.json</h4>
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
							<h3 id="type6">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input6">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
Token : 00ebb320dc888d343dd08e4d8c3fa9881535368159
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>
						 	<div class="highlight boderleft">
								<pre >
									<code class="html">
token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzZWFyY2hfcGFyYW0iOiJiMTEiLCJob3NwaXRhbF9pZCI6IjEiLCJlbXBsb3llZV9pZCI6IjM0NCIsInR5cGUiOiIzIiwic2VydmljZV90ZWFtX2lkIjoiMTIifQ.3v1_8S3IvaBU88HDzbK54ibWZcSjGfoYaQgsY3JYA3Y
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output6">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjpbeyJpZCI6MTYsIm5hbWUiOiJBaWRlbiBNYXJ0aW4iLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODE2IiwiZ3JvdXBfaWQiOiItTEQxSVhnTnlKcXAzWWpXaXdQbiIsImJlZCI6IjgtMiJ9LHsiaWQiOjE3LCJuYW1lIjoiSmFja3NvbiBUaG9tcHNvbiIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvcGF0aWVudC1kZWZhdWx0LnBuZyIsIm1ybiI6Ijk4Mzc4MTciLCJncm91cF9pZCI6Ii1MM0hWdlprWGdzWWZ2MksweWEzIiwiYmVkIjoiOS0xIn0seyJpZCI6MTgsIm5hbWUiOiJMb2dhbiBHYXJjaWEiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODE4IiwiZ3JvdXBfaWQiOiItTDNIT3duLUlVTS0zS3dnSFNOIiwiYmVkIjoiOS0yIn0seyJpZCI6MjUsIm5hbWUiOiJHYWJyaWVsIFdhbGtlciIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvcGF0aWVudC1kZWZhdWx0LnBuZyIsIm1ybiI6Ijk4Mzc4MjUiLCJncm91cF9pZCI6Ii1MNzRPdFZGT1dRaW9DRzhqUXNaIiwiYmVkIjoiMTMtMSJ9LHsiaWQiOjI2LCJuYW1lIjoiQ2FydGVyIEhhbGwiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODI2IiwiZ3JvdXBfaWQiOiItTDVnZE9qa3VvaWs0d0FnRmVweSIsImJlZCI6IjEzLTIifSx7ImlkIjoyNywibmFtZSI6IkpheWRlbiBBbGxlbiIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvcGF0aWVudC1kZWZhdWx0LnBuZyIsIm1ybiI6Ijk4Mzc4MjciLCJncm91cF9pZCI6Ii1MNzRJSzUtc1JGUDdoNGZ6LVUtIiwiYmVkIjoiMTQtMSJ9LHsiaWQiOjI4LCJuYW1lIjoiSm9obiBZb3VuZyIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvcGF0aWVudC1kZWZhdWx0LnBuZyIsIm1ybiI6Ijk4Mzc4MjgiLCJncm91cF9pZCI6Ii1MM0g4djlOWTFEc2lFUXJjek0tIiwiYmVkIjoiMTQtMiJ9LHsiaWQiOjI5LCJuYW1lIjoiTHVrZSBIZXJuYW5kZXoiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODI5IiwiZ3JvdXBfaWQiOiItTEI0dDdDVnEwZ0FHS1JFcUxrIiwiYmVkIjoiMTUtMSJ9LHsiaWQiOjMwLCJuYW1lIjoiQW50aG9ueSBLaW5nIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9wYXRpZW50LWRlZmF1bHQucG5nIiwibXJuIjoiOTgzNzgzMCIsImdyb3VwX2lkIjoiLUxCNFZGUFZsME5pRHJtbHN3ZUMiLCJiZWQiOiIxNS0yIn0seyJpZCI6MzEsIm5hbWUiOiJJc2FhYyBXcmlnaHQiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODMxIiwiZ3JvdXBfaWQiOiItTDQwRFJRY25EWF94UVdZblhLOSIsImJlZCI6IjE2LTEifSx7ImlkIjozMiwibmFtZSI6IkR5bGFuIExvcGV6IiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9wYXRpZW50LWRlZmF1bHQucG5nIiwibXJuIjoiOTgzNzgzMiIsImdyb3VwX2lkIjoiLUw3R3VnVGs0MGlTUEN0MGxKV1AiLCJiZWQiOiIxNi0yIn0seyJpZCI6MzMsIm5hbWUiOiJXeWF0dCBIaWxsIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9wYXRpZW50LWRlZmF1bHQucG5nIiwibXJuIjoiOTgzNzgzMyIsImdyb3VwX2lkIjoiLUw0LWh0QVZibWhCUFdsTmV6MkIiLCJiZWQiOiIxNy0xIn0seyJpZCI6MzQsIm5hbWUiOiJBbmRyZXcgU2NvdHQiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODM0IiwiZ3JvdXBfaWQiOiItTDRaZDQ3Rmh4T2kxQjVNakdnRSIsImJlZCI6IjE3LTIifSx7ImlkIjozNSwibmFtZSI6Ikpvc2h1YSBHcmVlbiIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvcGF0aWVudC1kZWZhdWx0LnBuZyIsIm1ybiI6Ijk4Mzc4MzUiLCJncm91cF9pZCI6Ii1MNFpjc1FrUVB5c0U0ZFY2bmI5IiwiYmVkIjoiMTgtMSJ9LHsiaWQiOjM2LCJuYW1lIjoiQ2hyaXN0b3BoZXIgQWRhbXMiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODM2IiwiZ3JvdXBfaWQiOiItTDU3ZmIyN083eXBUZ3poYUhmVCIsImJlZCI6IjE4LTIifSx7ImlkIjozNywibmFtZSI6IkdyYXlzb24gQmFrZXIiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODM3IiwiZ3JvdXBfaWQiOiItTDc4RGctVjJCaS1PNWw4OVV6biIsImJlZCI6IjE5LTEifSx7ImlkIjozOCwibmFtZSI6IkphY2sgR29uemFsZXoiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODM4IiwiZ3JvdXBfaWQiOiItTDc4RGZXRmJ0Z1FMNkZta0pReSIsImJlZCI6IjE5LTIifSx7ImlkIjozOSwibmFtZSI6Ikp1bGlhbiBOZWxzb24iLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODM5IiwiZ3JvdXBfaWQiOiItTDNSdms0Y2J2MmxEaDRmaXZiaiIsImJlZCI6IjIwLTEifV19.FSkG0FTU1WlNl7JVzYqFMPniH_a_ehBIARbBGtOL9qs"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6Imluc3VmZmljaWVudCBwYXJhbWV0ZXJzIn0.HEqSL2ckJ8hlCAbLKIVYmzM2bdKkXKPbVNC3LsA5R7I"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMywibWVzc2FnZSI6ImZvcmJpZGRlbiJ9.AvSXtHClYOacV0aDAJrERaLbWuvNcJZzMJuI_fhFcIA"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6IkludmFsaWQgaGVhZGVyIHBhc3NlZC4ifQ.Y4Jeb0RFe89kh4-G4rD7HWG_kbAcET5o4uFE8W9-_ZA"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMSwibWVzc2FnZSI6IllvdSBhcmUgdW5hdXRob3JpemVkIHRvIGFjY2VzcyB0aGlzIGxvY2F0aW9uLiJ9.As058aErTIv1Jbqnj4w5MdMzTvshS411w7ZoHc3Te_M"
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>