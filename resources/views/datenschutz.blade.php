<x-app-layout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24">
        <!-- Sub Navigation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-2 mb-6 flex flex-wrap gap-2">
            <button onclick="showContent('datenschutz')" id="btn-datenschutz" class="px-6 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer whitespace-nowrap bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-md">Datenschutzerklärung</button>
            <button onclick="showContent('agb')" id="btn-agb" class="px-6 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer whitespace-nowrap text-gray-700 hover:bg-gray-100">AGB</button>
            <button onclick="showContent('faq')" id="btn-faq" class="px-6 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer whitespace-nowrap text-gray-700 hover:bg-gray-100">FAQ</button>
            <button onclick="showContent('impressum')" id="btn-impressum" class="px-6 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer whitespace-nowrap text-gray-700 hover:bg-gray-100">Impressum</button>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <!-- Datenschutzerklärung Content -->
            <div id="content-datenschutz" class="prose max-w-none">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Datenschutzerklärung</h1>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">1. Verantwortlicher</h2>
                <p class="text-gray-700 mb-4">Verantwortlich für die Datenverarbeitung im Sinne der DSGVO:</p>
                <p class="text-gray-700 mb-2"><strong>Firma / Betreibername:</strong> Halit Akgöz</p>
                <p class="text-gray-700 mb-2"><strong>Adresse:</strong> Im Brühl 4, 89437 Haunsheim</p>
                <p class="text-gray-700 mb-4"><strong>E-Mail:</strong> info@energiequest.de</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">2. Art der verarbeiteten Daten</h2>
                <p class="text-gray-700 mb-4">Wir verarbeiten folgende personenbezogene Daten:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                        <li>Vor- und Nachname</li>
                        <li>Adresse</li>
                        <li>Telefonnummer</li>
                        <li>E-Mail-Adresse</li>
                        <li>IBAN</li>
                        <li>Vertrags- und Zählerdaten (Strom/Gas)</li>
                        <li>Hochgeladene Dokumente (z. B. Strom- oder Gasrechnungen)</li>
                        <li>Weiterempfehlungsdaten (z. B. Werber-ID, Empfehlungslink)</li>
                    </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">3. Zwecke der Datenverarbeitung</h2>
                <p class="text-gray-700 mb-4">Die Verarbeitung Ihrer Daten erfolgt zu folgenden Zwecken:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                        <li>Analyse bestehender Energieverträge</li>
                        <li>Erstellung und Übermittlung von Tarifoptimierungen</li>
                        <li>Weiterleitung von Vertragsunterlagen zur digitalen Unterschrift über rSign</li>
                        <li>Kommunikation mit Kunden</li>
                        <li>Ausstellung von Gutscheinen im Rahmen von Weiterempfehlungen</li>
                        <li>Nachweis und Verwaltung des Empfehlungsprogramms</li>
                    </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">4. Rechtsgrundlagen der Verarbeitung</h2>
                <p class="text-gray-700 mb-4">Die Datenverarbeitung erfolgt auf Grundlage von:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                        <li>Art. 6 Abs. 1 lit. b DSGVO (Vertragserfüllung)</li>
                        <li>Art. 6 Abs. 1 lit. a DSGVO (Einwilligung)</li>
                        <li>Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse, z. B. Serviceoptimierung)</li>
                    </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">5. Weitergabe an Dritte</h2>
                <p class="text-gray-700 mb-4">Eine Weitergabe personenbezogener Daten erfolgt ausschließlich an:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                        <li>Energieversorger im Rahmen eines Tarifwechsels</li>
                        <li>rSign / E-Signatur-Dienstleister zur digitalen Vertragsunterzeichnung</li>
                        <li>Partner zur Gutscheinabwicklung (falls erforderlich)</li>
                    </ul>
                <p class="text-gray-700 mb-4">Eine Weitergabe an unbeteiligte Dritte findet nicht statt.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">6. Speicherdauer</h2>
                <p class="text-gray-700 mb-4">Personenbezogene Daten werden nur so lange gespeichert, wie dies für die Vertragserfüllung sowie gesetzliche Aufbewahrungspflichten erforderlich ist. Im Einzelnen:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                    <li><strong>Vertragsdaten:</strong> 10 Jahre nach Vertragsende (gemäß handelsrechtlicher Aufbewahrungspflichten)</li>
                    <li><strong>Hochgeladene Rechnungen:</strong> 6 Monate nach Abschluss der Tarifoptimierung, sofern keine weitergehende Einwilligung vorliegt</li>
                    <li><strong>Kontaktdaten (Name, E-Mail, Telefon):</strong> Bis zur Löschung des Kontos oder Widerruf der Einwilligung, maximal jedoch 3 Jahre nach letztem Kontakt</li>
                    <li><strong>Empfehlungsdaten:</strong> 3 Jahre nach Ausstellung des letzten Gutscheins oder bis zur Löschung des Kontos</li>
                    <li><strong>Session-Cookies:</strong> Werden automatisch gelöscht, wenn der Browser geschlossen wird</li>
                    <li><strong>Log-Dateien:</strong> 7 Tage (Server-Logs zur Sicherstellung der Funktionalität)</li>
                </ul>
                <p class="text-gray-700 mb-4">Nach Ablauf der Speicherfristen werden die Daten routinemäßig und entsprechend den gesetzlichen Vorschriften gelöscht, sofern sie nicht zur Erfüllung eines Vertrags oder zur Geltendmachung von Ansprüchen erforderlich sind.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">7. Rechte der Nutzer</h2>
                <p class="text-gray-700 mb-4">Sie haben jederzeit das Recht auf:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                    <li><strong>Auskunft</strong> (Art. 15 DSGVO): Sie können Auskunft über die von uns gespeicherten personenbezogenen Daten verlangen</li>
                    <li><strong>Berichtigung</strong> (Art. 16 DSGVO): Sie können die Berichtigung unrichtiger Daten verlangen</li>
                    <li><strong>Löschung</strong> (Art. 17 DSGVO): Sie können die Löschung Ihrer Daten verlangen, soweit keine gesetzlichen Aufbewahrungspflichten entgegenstehen</li>
                    <li><strong>Einschränkung der Verarbeitung</strong> (Art. 18 DSGVO): Sie können die Einschränkung der Verarbeitung Ihrer Daten verlangen</li>
                    <li><strong>Datenübertragbarkeit</strong> (Art. 20 DSGVO): Sie können Ihre Daten in einem strukturierten, gängigen und maschinenlesbaren Format erhalten</li>
                    <li><strong>Widerruf erteilter Einwilligungen</strong> (Art. 7 Abs. 3 DSGVO): Sie können erteilte Einwilligungen jederzeit widerrufen</li>
                    <li><strong>Widerspruch</strong> (Art. 21 DSGVO): Sie können der Verarbeitung Ihrer Daten aus Gründen, die sich aus Ihrer besonderen Situation ergeben, widersprechen, soweit die Verarbeitung auf Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse) beruht</li>
                    </ul>
                <p class="text-gray-700 mb-4">Zur Ausübung Ihrer Rechte können Sie sich jederzeit an uns wenden:</p>
                <p class="text-gray-700 mb-2"><strong>E-Mail:</strong> info@energiequest.de</p>
                <p class="text-gray-700 mb-4"><strong>Postanschrift:</strong> Halit Akgöz, Im Brühl 4, 89437 Haunsheim</p>
                <p class="text-gray-700 mb-4">Sie haben zudem das Recht, sich bei einer Aufsichtsbehörde über die Verarbeitung Ihrer personenbezogenen Daten zu beschweren (Art. 77 DSGVO).</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">8. Datensicherheit</h2>
                <p class="text-gray-700 mb-4">Ihre Daten werden verschlüsselt übertragen und in einer sicheren technischen Umgebung gespeichert.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">9. Einwilligung zur Datenverarbeitung</h2>
                <p class="text-gray-700 mb-4">Vor Nutzung des Services ist folgende Einwilligung erforderlich:</p>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                    <p class="text-gray-700 mb-3 italic">"Ich willige ein, dass meine personenbezogenen Daten und hochgeladenen Dokumente ausschließlich zum Zweck der Tarifoptimierung, Vertragsabwicklung und digitalen Signatur über rSign verarbeitet werden."</p>
                    <p class="text-gray-700 italic">"Ich bestätige, dass ich zur Übermittlung der Daten berechtigt bin."</p>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">10. Cookie- und Tracking-Hinweis</h2>
                <p class="text-gray-700 mb-4">Wir verwenden auf unserer Website folgende Arten von Cookies:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                    <li><strong>Notwendige Cookies:</strong> Diese Cookies sind für die Grundfunktionen der Website erforderlich und können nicht deaktiviert werden. Sie werden in der Regel nur als Reaktion auf von Ihnen durchgeführte Aktionen gesetzt, die einer Dienstanfrage gleichkommen (z. B. Festlegen Ihrer Datenschutzeinstellungen, Anmelden oder Ausfüllen von Formularen).</li>
                    <li><strong>Funktionale Cookies:</strong> Diese Cookies ermöglichen es der Website, erweiterte Funktionalität und Personalisierung bereitzustellen.</li>
                    <li><strong>Tracking-Cookies:</strong> Derzeit verwenden wir keine Tracking-Cookies oder Analytics-Tools. Sollten wir in Zukunft Tracking-Tools einsetzen, erfolgt dies ausschließlich mit Ihrer ausdrücklichen Einwilligung über ein Cookie-Opt-in-Banner.</li>
                </ul>
                <p class="text-gray-700 mb-4">Sie können Ihre Cookie-Einstellungen jederzeit über das Cookie-Banner ändern, das beim ersten Besuch der Website angezeigt wird. Die Einstellungen werden in Ihrem Browser gespeichert.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">11. Empfehlungsprogramm – Datenschutz</h2>
                <p class="text-gray-700 mb-4">Im Rahmen des Empfehlungsprogramms wird eine pseudonymisierte Werber-ID verarbeitet.</p>
                <p class="text-gray-700 mb-4">Ein Gutscheinanspruch entsteht ausschließlich bei erfolgreichem Tarifwechsel.</p>
            </div>

            <!-- AGB Content -->
            <div id="content-agb" class="prose max-w-none hidden">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Allgemeine Geschäftsbedingungen (AGB)</h1>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">1. Geltungsbereich</h2>
                <p class="text-gray-700 mb-4">Diese AGB gelten für die Nutzung unserer Plattform zur Optimierung von Strom- und Gastarifen.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">2. Leistungsbeschreibung</h2>
                <p class="text-gray-700 mb-4">Wir bieten folgende Leistungen an:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                        <li>Prüfung bestehender Energieverträge anhand hochgeladener Rechnungen</li>
                        <li>Erstellung eines Tarifoptimierungsvorschlags</li>
                        <li>Vorbereitung und Versand digitaler Vertragsunterlagen</li>
                        <li>Elektronische Signaturabwicklung über rSign</li>
                        <li>Empfehlungsprogramm inklusive Gutschein-Ausstellung</li>
                    </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">3. Vertragsschluss</h2>
                <p class="text-gray-700 mb-4">Der Vertrag kommt zustande, sobald der Kunde seine Daten übermittelt und der Optimierungsprozess gestartet wird.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">4. Pflichten des Kunden</h2>
                <p class="text-gray-700 mb-4">Der Kunde verpflichtet sich:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                        <li>ausschließlich korrekte und vollständige Angaben zu machen</li>
                        <li>nur eigene oder berechtigte Rechnungen hochzuladen</li>
                        <li>erhaltene Vertragslinks vertraulich zu behandeln</li>
                    </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">5. Vergütung</h2>
                <p class="text-gray-700 mb-4">Der Service ist für den Kunden kostenfrei.</p>
                <p class="text-gray-700 mb-4">Die Vergütung erfolgt über Provisionen von Energieversorgern.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">6. Empfehlungen und Gutscheine</h2>
                <p class="text-gray-700 mb-4"><strong>Voraussetzungen für einen Gutscheinanspruch:</strong></p>
                <p class="text-gray-700 mb-4">Ein Gutscheinanspruch entsteht ausschließlich, wenn alle folgenden Bedingungen erfüllt sind:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                    <li>Eine geworbene Person registriert sich über Ihren Empfehlungscode</li>
                    <li>Die geworbene Person lädt ihre Jahresabrechnung hoch</li>
                    <li>Ein Tarifwechsel erfolgreich abgeschlossen wird (der Energieversorger nimmt den Vertrag an)</li>
                    <li>Der Vertrag wird nicht widerrufen</li>
                </ul>
                <p class="text-gray-700 mb-4"><strong>Kein Anspruch auf Gutscheine besteht, wenn:</strong></p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                    <li>Der Energieversorger den Tarifwechsel ablehnt</li>
                    <li>Die geworbene Person den Vertrag widerruft</li>
                    <li>Die geworbene Person keine gültige Jahresabrechnung hochlädt</li>
                    <li>Die geworbene Person sich nicht registriert oder den Prozess abbricht</li>
                </ul>
                <p class="text-gray-700 mb-4"><strong>Gutscheinausstellung:</strong></p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                    <li>Gutscheine werden per E-Mail innerhalb von 1-3 Werktagen nach erfolgreichem Tarifwechsel versendet</li>
                    <li>Die Höhe des Gutscheins richtet sich nach dem erreichten Level</li>
                    <li>Es besteht kein Rechtsanspruch auf Gutscheine, wenn die oben genannten Bedingungen nicht vollständig erfüllt sind</li>
                </ul>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
                    <p class="text-gray-700 mb-2"><strong>Wichtiger Hinweis:</strong></p>
                    <p class="text-gray-700">Nicht jede Empfehlung führt automatisch zu einem Gutschein. Ein Gutschein wird nur gewährt, wenn der gesamte Prozess (Registrierung, Upload der Jahresabrechnung und erfolgreicher Tarifwechsel) abgeschlossen wird.</p>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">7. Haftung</h2>
                <p class="text-gray-700 mb-4">Wir haften nicht für:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                        <li>Ablehnung von Verträgen durch Energieversorger</li>
                        <li>Preisänderungen der Anbieter</li>
                        <li>Verzögerungen durch Energieversorger oder rSign</li>
                    </ul>
                <p class="text-gray-700 mb-4">Eine Haftung besteht nur bei Vorsatz oder grober Fahrlässigkeit.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">8. Haftungserweiterungen</h2>
                <p class="text-gray-700 mb-4">Wir übernehmen keine Garantie für:</p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                    <li>tatsächliche Einsparungen</li>
                    <li>Annahme des Wechsels durch Anbieter</li>
                    <li>Richtigkeit der Kundendaten</li>
                    <li>Verzögerungen durch Energieversorger, Netzbetreiber oder rSign</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">9. Widerrufsrecht</h2>
                <p class="text-gray-700 mb-4"><strong>Widerrufsbelehrung</strong></p>
                <p class="text-gray-700 mb-4"><strong>Widerrufsrecht</strong></p>
                <p class="text-gray-700 mb-4">Sie haben das Recht, binnen vierzehn Tagen ohne Angabe von Gründen diesen Vertrag zu widerrufen.</p>
                <p class="text-gray-700 mb-4">Die Widerrufsfrist beträgt vierzehn Tage ab dem Tag des Vertragsschlusses.</p>
                <p class="text-gray-700 mb-4">Um Ihr Widerrufsrecht auszuüben, müssen Sie uns (Halit Akgöz, Im Brühl 4, 89437 Haunsheim, E-Mail: info@energiequest.de) mittels einer eindeutigen Erklärung (z. B. ein mit der Post versandter Brief, Telefax oder E-Mail) über Ihren Entschluss, diesen Vertrag zu widerrufen, informieren. Sie können dafür das beigefügte Muster-Widerrufsformular verwenden, das jedoch nicht vorgeschrieben ist.</p>
                <p class="text-gray-700 mb-4">Zur Wahrung der Widerrufsfrist reicht es aus, dass Sie die Mitteilung über die Ausübung des Widerrufsrechts vor Ablauf der Widerrufsfrist absenden.</p>
                
                <p class="text-gray-700 mb-4"><strong>Folgen des Widerrufs</strong></p>
                <p class="text-gray-700 mb-4">Wenn Sie diesen Vertrag widerrufen, haben wir Ihnen alle Zahlungen, die wir von Ihnen erhalten haben, unverzüglich und spätestens binnen vierzehn Tagen ab dem Tag zurückzuzahlen, an dem die Mitteilung über Ihren Widerruf dieses Vertrags bei uns eingegangen ist. Für diese Rückzahlung verwenden wir dasselbe Zahlungsmittel, das Sie bei der ursprünglichen Transaktion eingesetzt haben, es sei denn, mit Ihnen wurde ausdrücklich etwas anderes vereinbart; in keinem Fall werden Ihnen wegen dieser Rückzahlung Entgelte berechnet.</p>
                
                <p class="text-gray-700 mb-4"><strong>Besondere Hinweise</strong></p>
                <p class="text-gray-700 mb-4">Da es sich bei unserem Service um eine digitale Dienstleistung handelt, die sofort nach Vertragsschluss erbracht wird, können Sie Ihr Widerrufsrecht verlieren, wenn Sie ausdrücklich zustimmen, dass wir vor Ablauf der Widerrufsfrist mit der Ausführung der Dienstleistung beginnen.</p>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
                    <p class="text-gray-700 mb-2"><strong>Widerrufsverzicht – Nutzerbestätigung</strong></p>
                    <p class="text-gray-700 italic">"Ich stimme ausdrücklich zu, dass mit der Dienstleistung sofort begonnen wird. Mir ist bewusst, dass ich dadurch mein Widerrufsrecht verliere."</p>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">10. Muster-Widerrufsformular</h2>
                <div class="bg-gray-50 border border-gray-300 rounded-lg p-6 mb-4">
                    <p class="text-gray-700 mb-4"><strong>(Wenn Sie den Vertrag widerrufen wollen, dann füllen Sie bitte dieses Formular aus und senden Sie es zurück.)</strong></p>
                    <p class="text-gray-700 mb-2">An:</p>
                    <p class="text-gray-700 mb-4">Halit Akgöz<br>Im Brühl 4<br>89437 Haunsheim<br>E-Mail: info@energiequest.de</p>
                    <p class="text-gray-700 mb-4">Hiermit widerrufe(n) ich/wir (*) den von mir/uns (*) abgeschlossenen Vertrag über den Kauf der folgenden Waren (*)/die Erbringung der folgenden Dienstleistung (*)</p>
                    <p class="text-gray-700 mb-2">Bestellt am (*)/erhalten am (*):</p>
                    <p class="text-gray-700 mb-4">_________________________________</p>
                    <p class="text-gray-700 mb-2">Name des/der Verbraucher(s):</p>
                    <p class="text-gray-700 mb-4">_________________________________</p>
                    <p class="text-gray-700 mb-2">Anschrift des/der Verbraucher(s):</p>
                    <p class="text-gray-700 mb-4">_________________________________</p>
                    <p class="text-gray-700 mb-2">Unterschrift des/der Verbraucher(s) (nur bei Mitteilung auf Papier):</p>
                    <p class="text-gray-700 mb-4">_________________________________</p>
                    <p class="text-gray-700 mb-2">Datum:</p>
                    <p class="text-gray-700 mb-4">_________________________________</p>
                    <p class="text-gray-700 text-sm">(*) Unzutreffendes streichen.</p>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">11. Widerrufsverzicht – Nutzerbestätigung</h2>
                <p class="text-gray-700 mb-4">Wenn Sie ausdrücklich zustimmen, dass wir mit der Dienstleistung sofort beginnen sollen, verlieren Sie Ihr Widerrufsrecht. Diese Zustimmung muss klar und deutlich erfolgen.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">12. Hinweis zu Provisionen</h2>
                <p class="text-gray-700 mb-4">Wir weisen transparent darauf hin, dass wir im Falle eines erfolgreichen Tarifwechsels eine Provision vom Energieversorger erhalten. Dies hat keinen Einfluss auf die Tarifempfehlung.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">15. Nutzerrichtlinien für Empfehlungen</h2>
                <p class="text-gray-700 mb-4"><strong>Hinweis zum Teilen von Empfehlungscodes:</strong></p>
                <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
                    <li>Teilen Sie Ihren Code nur mit Personen, die Sie kennen und die möglicherweise Interesse an unserem Service haben</li>
                    <li>Versenden Sie keine unerwünschten Nachrichten (Spam) oder Massen-E-Mails</li>
                    <li>Respektieren Sie die Privatsphäre anderer Personen</li>
                    <li>Verwenden Sie keine automatisierten Systeme oder Bots zum Versenden von Empfehlungen</li>
                    <li>Halten Sie sich an alle geltenden Gesetze, insbesondere das Gesetz gegen den unlauteren Wettbewerb (UWG)</li>
                </ul>
                <p class="text-gray-700 mb-4"><strong>Konsequenzen bei Verstößen:</strong></p>
                <p class="text-gray-700 mb-4">Bei Verstoß gegen diese Richtlinien oder bei unerlaubten Werbemethoden behalten wir uns vor, Gutscheine zu verweigern, Accounts zu sperren oder rechtliche Schritte einzuleiten. Wir distanzieren uns ausdrücklich von unerlaubten Werbemethoden und unzumutbaren Belästigungen im Sinne von § 16 UWG.</p>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
                    <p class="text-gray-700 mb-2"><strong>Wichtiger Hinweis:</strong></p>
                    <p class="text-gray-700">Sie sind selbst verantwortlich für die Art und Weise, wie Sie Ihren Empfehlungscode weitergeben. Unerwünschte Werbung (Spam) ist gesetzlich untersagt und kann zu rechtlichen Konsequenzen führen.</p>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">13. Datenschutz</h2>
                <p class="text-gray-700 mb-4">Es gilt die jeweils aktuelle Datenschutzerklärung.</p>

                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">14. Schlussbestimmungen</h2>
                <p class="text-gray-700 mb-4">Sollten einzelne Bestimmungen unwirksam sein, bleibt die Wirksamkeit der übrigen Regelungen unberührt.</p>
            </div>

            <!-- FAQ Content -->
            <div id="content-faq" class="prose max-w-none hidden">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">FAQ – Häufig gestellte Fragen</h1>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">1. Wie funktioniert die Tarifoptimierung?</h3>
                        <p class="text-gray-700">Sie laden Ihre Strom- oder Gasrechnung hoch. Wir analysieren diese und senden Ihnen ein digitales Angebot.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">2. Ist der Service kostenlos?</h3>
                        <p class="text-gray-700">Ja. Unsere Vergütung erfolgt über Provisionen von Energieversorgern.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">3. Wie unterschreibe ich den neuen Vertrag?</h3>
                        <p class="text-gray-700">Sie erhalten einen Link per SMS oder E-Mail und unterschreiben sicher über rSign.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">4. Was passiert mit meinen Daten?</h3>
                        <p class="text-gray-700">Ihre Daten werden ausschließlich zur Tarifoptimierung und Vertragsabwicklung verwendet.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">5. Wie funktioniert der Empfehlungslink?</h3>
                        <p class="text-gray-700">Sie erhalten einen persönlichen Link. Bei erfolgreichem Tarifwechsel einer geworbenen Person (Registrierung + Jahresabrechnung hochgeladen + Energieversorger nimmt den Vertrag an) erhalten Sie einen Gutschein. <strong>Wichtig:</strong> Ein Gutschein wird nur gewährt, wenn der gesamte Prozess erfolgreich abgeschlossen wird. Es besteht kein Anspruch auf Gutscheine, wenn der Energieversorger den Tarifwechsel ablehnt oder der Vertrag widerrufen wird.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">6. Wie lange dauert der Wechsel?</h3>
                        <p class="text-gray-700">In der Regel wenige Tage bis maximal drei Wochen – abhängig vom Energieversorger.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">7. Kann ich den Vertrag widerrufen?</h3>
                        <p class="text-gray-700">Nach Zustimmung zur sofortigen Leistungserbringung entfällt das Widerrufsrecht.</p>
                    </div>
                </div>
            </div>

            <!-- Impressum Content -->
            <div id="content-impressum" class="prose max-w-none hidden">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Impressum</h1>
                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">Angaben gemäß § 5 TMG</h2>
                <p class="text-gray-700 mb-2"><strong>Firmenname / Betreiber:</strong> Halit Akgöz</p>
                <p class="text-gray-700 mb-2"><strong>Adresse:</strong> Im Brühl 4, 89437 Haunsheim</p>
                <p class="text-gray-700 mb-2"><strong>Telefon:</strong> +49 160 4535 192</p>
                <p class="text-gray-700 mb-2"><strong>E-Mail:</strong> info@energiequest.de</p>
                <p class="text-gray-700 mb-4"><strong>Umsatzsteuer-ID:</strong> DE351988445</p>
                
                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">Handelsregister</h2>
                <p class="text-gray-700 mb-2">Die Tätigkeit erfolgt als Einzelunternehmen. Ein Handelsregistereintrag liegt derzeit nicht vor.</p>
                
                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h2>
                <p class="text-gray-700 mb-2"><strong>Name:</strong> Halit Akgöz</p>
                <p class="text-gray-700 mb-2"><strong>Adresse:</strong> Im Brühl 4, 89437 Haunsheim</p>
                
                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">Haftungsausschluss</h2>
                <p class="text-gray-700 mb-4"><strong>Haftung für Inhalte</strong></p>
                <p class="text-gray-700 mb-4">Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.</p>
                
                <p class="text-gray-700 mb-4"><strong>Haftung für Links</strong></p>
                <p class="text-gray-700 mb-4">Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich.</p>
                
                <p class="text-gray-700 mb-4"><strong>Urheberrecht</strong></p>
                <p class="text-gray-700 mb-4">Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.</p>
            </div>
        </div>
    </main>

    <script>
        function showContent(type) {
            // Hide all content
            document.getElementById('content-datenschutz').classList.add('hidden');
            document.getElementById('content-agb').classList.add('hidden');
            document.getElementById('content-faq').classList.add('hidden');
            document.getElementById('content-impressum').classList.add('hidden');

            // Remove active state from all buttons
            document.getElementById('btn-datenschutz').classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-500', 'text-white', 'shadow-md');
            document.getElementById('btn-datenschutz').classList.add('text-gray-700', 'hover:bg-gray-100');
            document.getElementById('btn-agb').classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-500', 'text-white', 'shadow-md');
            document.getElementById('btn-agb').classList.add('text-gray-700', 'hover:bg-gray-100');
            document.getElementById('btn-faq').classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-500', 'text-white', 'shadow-md');
            document.getElementById('btn-faq').classList.add('text-gray-700', 'hover:bg-gray-100');
            document.getElementById('btn-impressum').classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-500', 'text-white', 'shadow-md');
            document.getElementById('btn-impressum').classList.add('text-gray-700', 'hover:bg-gray-100');

            // Show selected content
            document.getElementById('content-' + type).classList.remove('hidden');

            // Add active state to selected button
            const activeButton = document.getElementById('btn-' + type);
            activeButton.classList.remove('text-gray-700', 'hover:bg-gray-100');
            activeButton.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-indigo-500', 'text-white', 'shadow-md');
        }
    </script>
</x-app-layout>
