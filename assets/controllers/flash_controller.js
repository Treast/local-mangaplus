import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static values = { url: String }

  connect() {
    this.eventSource = new EventSource(this.urlValue);

    this.eventSource.onmessage = (event) => {
      const data = JSON.parse(event.data);

      // On injecte directement le HTML reçu du serveur
      if (data.html) {
        this.element.insertAdjacentHTML('afterbegin', data.html);
      }
    };
  }

  disconnect() {
    if (this.eventSource) this.eventSource.close();
  }
}
