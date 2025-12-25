<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Datenschutz') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="sm:pb-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-6">
            <div class="bg-white shadow rounded-lg p-6 space-y-8">
                
                <h1 class="text-3xl font-bold mb-6">Datenschutzerklärung</h1>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">1. Verantwortlicher</h2>
                    <p class="mb-2">Verantwortlich für die Datenverarbeitung im Sinne der DSGVO:</p>
                    <p class="mb-2"><strong>Firma / Betreibername:</strong> Halit Akgöz</p>
                    <p class="mb-2"><strong>Adresse:</strong> Im Brühl 4, 89437 Haunsheim</p>
                    <p class="mb-2"><strong>E-Mail:</strong> info@energiequest.de</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">2. Art der verarbeiteten Daten</h2>
                    <p class="mb-4">Wir verarbeiten folgende personenbezogene Daten:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Vor- und Nachname</li>
                        <li>Adresse</li>
                        <li>Telefonnummer</li>
                        <li>E-Mail-Adresse</li>
                        <li>IBAN</li>
                        <li>Vertrags- und Zählerdaten (Strom/Gas)</li>
                        <li>Hochgeladene Dokumente (z. B. Strom- oder Gasrechnungen)</li>
                        <li>Weiterempfehlungsdaten (z. B. Werber-ID, Empfehlungslink)</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">3. Zwecke der Datenverarbeitung</h2>
                    <p class="mb-4">Die Verarbeitung Ihrer Daten erfolgt zu folgenden Zwecken:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Analyse bestehender Energieverträge</li>
                        <li>Erstellung und Übermittlung von Tarifoptimierungen</li>
                        <li>Weiterleitung von Vertragsunterlagen zur digitalen Unterschrift über rSign</li>
                        <li>Kommunikation mit Kunden</li>
                        <li>Ausstellung von Gutscheinen im Rahmen von Weiterempfehlungen</li>
                        <li>Nachweis und Verwaltung des Empfehlungsprogramms</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">4. Rechtsgrundlagen der Verarbeitung</h2>
                    <p class="mb-4">Die Datenverarbeitung erfolgt auf Grundlage von:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Art. 6 Abs. 1 lit. b DSGVO (Vertragserfüllung)</li>
                        <li>Art. 6 Abs. 1 lit. a DSGVO (Einwilligung)</li>
                        <li>Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse, z. B. Serviceoptimierung)</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">5. Weitergabe an Dritte</h2>
                    <p class="mb-4">Eine Weitergabe personenbezogener Daten erfolgt ausschließlich an:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Energieversorger im Rahmen eines Tarifwechsels</li>
                        <li>rSign / E-Signatur-Dienstleister zur digitalen Vertragsunterzeichnung</li>
                        <li>Partner zur Gutscheinabwicklung (falls erforderlich)</li>
                    </ul>
                    <p class="mt-4">Eine Weitergabe an unbeteiligte Dritte findet nicht statt.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">6. Speicherdauer</h2>
                    <p class="mb-2">Personenbezogene Daten werden nur so lange gespeichert, wie dies für die Vertragserfüllung sowie gesetzliche Aufbewahrungspflichten erforderlich ist.</p>
                    <p>Hochgeladene Rechnungen werden nach Abschluss der Tarifoptimierung gelöscht, sofern keine weitergehende Einwilligung vorliegt.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">7. Rechte der Nutzer</h2>
                    <p class="mb-4">Sie haben jederzeit das Recht auf:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Auskunft</li>
                        <li>Berichtigung</li>
                        <li>Löschung</li>
                        <li>Einschränkung der Verarbeitung</li>
                        <li>Datenübertragbarkeit</li>
                        <li>Widerruf erteilter Einwilligungen</li>
                    </ul>
                    <p class="mt-4"><strong>Kontakt:</strong> info@energiequest.de</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">8. Datensicherheit</h2>
                    <p>Ihre Daten werden verschlüsselt übertragen und in einer sicheren technischen Umgebung gespeichert.</p>
                </section>

                <hr class="my-8 border-gray-300">

                <h1 class="text-3xl font-bold mb-6">Allgemeine Geschäftsbedingungen (AGB)</h1>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">1. Geltungsbereich</h2>
                    <p>Diese AGB gelten für die Nutzung unserer Plattform zur Optimierung von Strom- und Gastarifen.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">2. Leistungsbeschreibung</h2>
                    <p class="mb-4">Wir bieten folgende Leistungen an:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Prüfung bestehender Energieverträge anhand hochgeladener Rechnungen</li>
                        <li>Erstellung eines Tarifoptimierungsvorschlags</li>
                        <li>Vorbereitung und Versand digitaler Vertragsunterlagen</li>
                        <li>Elektronische Signaturabwicklung über rSign</li>
                        <li>Empfehlungsprogramm inklusive Gutschein-Ausstellung</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">3. Vertragsschluss</h2>
                    <p>Der Vertrag kommt zustande, sobald der Kunde seine Daten übermittelt und der Optimierungsprozess gestartet wird.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">4. Pflichten des Kunden</h2>
                    <p class="mb-4">Der Kunde verpflichtet sich:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>ausschließlich korrekte und vollständige Angaben zu machen</li>
                        <li>nur eigene oder berechtigte Rechnungen hochzuladen</li>
                        <li>erhaltene Vertragslinks vertraulich zu behandeln</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">5. Vergütung</h2>
                    <p class="mb-2">Der Service ist für den Kunden kostenfrei.</p>
                    <p>Die Vergütung erfolgt über Provisionen von Energieversorgern.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">6. Empfehlungen und Gutscheine</h2>
                    <p>Ein Gutscheinanspruch entsteht, sobald ein geworbener Kunde einen erfolgreichen Tarifwechsel durchführt.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">7. Haftung</h2>
                    <p class="mb-4">Wir haften nicht für:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Ablehnung von Verträgen durch Energieversorger</li>
                        <li>Preisänderungen der Anbieter</li>
                        <li>Verzögerungen durch Energieversorger oder rSign</li>
                    </ul>
                    <p class="mt-4">Eine Haftung besteht nur bei Vorsatz oder grober Fahrlässigkeit.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">8. Widerrufsrecht</h2>
                    <p>Da es sich um eine digitale Dienstleistung handelt, die sofort erbracht wird, entfällt das Widerrufsrecht, sofern der Kunde ausdrücklich zustimmt.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">9. Datenschutz</h2>
                    <p>Es gilt die jeweils aktuelle Datenschutzerklärung.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">10. Schlussbestimmungen</h2>
                    <p>Sollten einzelne Bestimmungen unwirksam sein, bleibt die Wirksamkeit der übrigen Regelungen unberührt.</p>
                </section>

                <hr class="my-8 border-gray-300">

                <h1 class="text-3xl font-bold mb-6">FAQ – Häufig gestellte Fragen</h1>

                <section class="space-y-6">
                    <div>
                        <h3 class="text-xl font-semibold mb-2">1. Wie funktioniert die Tarifoptimierung?</h3>
                        <p>Sie laden Ihre Strom- oder Gasrechnung hoch. Wir analysieren diese und senden Ihnen ein digitales Angebot.</p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-2">2. Ist der Service kostenlos?</h3>
                        <p>Ja. Unsere Vergütung erfolgt über Provisionen von Energieversorgern.</p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-2">3. Wie unterschreibe ich den neuen Vertrag?</h3>
                        <p>Sie erhalten einen Link per SMS oder E-Mail und unterschreiben sicher über rSign.</p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-2">4. Was passiert mit meinen Daten?</h3>
                        <p>Ihre Daten werden ausschließlich zur Tarifoptimierung und Vertragsabwicklung verwendet.</p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-2">5. Wie funktioniert der Empfehlungslink?</h3>
                        <p>Sie erhalten einen persönlichen Link. Bei erfolgreichem Tarifwechsel einer geworbenen Person erhalten Sie einen Gutschein.</p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-2">6. Wie lange dauert der Wechsel?</h3>
                        <p>In der Regel wenige Tage bis maximal drei Wochen – abhängig vom Energieversorger.</p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-2">7. Kann ich den Vertrag widerrufen?</h3>
                        <p>Nach Zustimmung zur sofortigen Leistungserbringung entfällt das Widerrufsrecht.</p>
                    </div>
                </section>

                <hr class="my-8 border-gray-300">

                <h1 class="text-3xl font-bold mb-6">Weitere rechtliche Pflichtangaben</h1>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">Impressum</h2>
                    <p class="mb-2"><strong>Firmenname:</strong> Halit Akgöz</p>
                    <p class="mb-2"><strong>Rechtsform:</strong> Einzelunternehmen</p>
                    <p class="mb-2"><strong>Adresse:</strong> Im Brühl 4, 89437 Haunsheim</p>
                    <p class="mb-2"><strong>Telefon:</strong> 01604535192</p>
                    <p class="mb-2"><strong>E-Mail:</strong> info@energiequest.de</p>
                    <p class="mb-2"><strong>Umsatzsteuer-ID:</strong> DE351988445</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">Einwilligung zur Datenverarbeitung</h2>
                    <p class="mb-4">Vor Nutzung des Services ist folgende Einwilligung erforderlich:</p>
                    <p class="mb-2">„Ich willige ein, dass meine personenbezogenen Daten und hochgeladenen Dokumente ausschließlich zum Zweck der Tarifoptimierung, Vertragsabwicklung und digitalen Signatur über rSign verarbeitet werden."</p>
                    <p>„Ich bestätige, dass ich zur Übermittlung der Daten berechtigt bin."</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">Widerrufsverzicht – Nutzerbestätigung</h2>
                    <p>„Ich stimme ausdrücklich zu, dass mit der Dienstleistung sofort begonnen wird. Mir ist bewusst, dass ich dadurch mein Widerrufsrecht verliere."</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">Hinweis zu Provisionen</h2>
                    <p>Wir weisen transparent darauf hin, dass wir im Falle eines erfolgreichen Tarifwechsels eine Provision vom Energieversorger erhalten. Dies hat keinen Einfluss auf die Tarifempfehlung.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">Cookie- und Tracking-Hinweis</h2>
                    <p>Sofern Tracking-Tools eingesetzt werden, erfolgt dies ausschließlich mit Einwilligung über ein Cookie-Opt-in-Banner.</p>
                    <p class="mt-2">Werden keine Tracking-Tools eingesetzt, erfolgt ein entsprechender Hinweis in der Datenschutzerklärung.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">Haftungserweiterungen</h2>
                    <p class="mb-4">Wir übernehmen keine Garantie für:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>tatsächliche Einsparungen</li>
                        <li>Annahme des Wechsels durch Anbieter</li>
                        <li>Richtigkeit der Kundendaten</li>
                        <li>Verzögerungen durch Energieversorger, Netzbetreiber oder rSign</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold mb-4">Empfehlungsprogramm – Datenschutz</h2>
                    <p class="mb-2">Im Rahmen des Empfehlungsprogramms wird eine pseudonymisierte Werber-ID verarbeitet.</p>
                    <p>Ein Gutscheinanspruch entsteht ausschließlich bei erfolgreichem Tarifwechsel.</p>
                </section>

            </div>
        </div>
    </div>

    <x-bottom-nav />
</x-app-layout>
