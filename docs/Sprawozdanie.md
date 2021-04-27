# Sprawozdanie z testów obiążeniowych.

W katalogu 'docs' zamieściliśmy wykresy obrazujące stosunek przepustowości 'Throughput' oraz zmienność 'Deviation' w czasie.
W plikach results mieszczą się raporty przedstawiające wartości paramtrów 'Latency'  oraz Sample Time oznaczonego w raporcie jako 'elapsed'.
W nazwie pliku numer odpowiada ilości urzytkowników, wykonujących żądanie do serwera hostującego aplikację.

Dla 6500 użytkowników:
Średnia wartość Sample time: 1761 ms, z najwyższą wartością: 131312
Średnia wartość Latency: 1761 ms, z najwyższa wartością: 131312
Throughput: 18,125.763/min
Deviation:10801
Wszystkie żądania HTTP zostały zrealizowane.

Dla 7500 użytkowników:
Średnia wartość Sample time: 2726 ms, z najwyższą wartością: 131602
Średnia wartość Latency: 2726 ms, z najwyższa wartością: 131602
Throughput: 16,586,437/min
Deviation:17209
Z pośród wszystkich żądań  149 skończyło się niepowodzeniem.

Podsumowanie:
Limitem użytkowników mogących korzystać z aplikacji jest liczba z zakresu 6500 - 7500.
Dla 7500 użytkowników aplikacja w nie była wstanie obsłużyc wszystkich żądań.
Wartość Throughput była wysoka w obydwu testach, nie mniej cechowały się sporą wartością dewiacji wyników.
Opóźnienie odpowiedzi przy mierzonych ilościach użytkowników było wysokie wynoszące od około 2 do 3 sekund.

