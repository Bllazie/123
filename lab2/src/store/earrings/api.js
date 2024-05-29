import Api from '@/api/index';

class Earrings extends Api {

  /**
   * Вернет список всех драгоценностей
   * @returns {Promise<Response>}
   */
  earrings = () => this.rest('/earrings/list.json');

  /**
   * Удалит драгоценность по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = ( id ) => this.rest('/earrings/delete-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then(() => id) // then - заглушка, пока метод ничего не возвращает

  /**
   * Создаст новую запись в таблице
   * @param earring объект блюда, взятый из EarringsForm
   * @returns {Promise<Response>}
   */
  add = ( earring ) => this.rest('/earrings/add-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(earring),
  }).then(() => ({...earring, id: new Date().getTime()})) // then - заглушка, пока метод ничего не возвращает

  /**
   * Отправит измененную запись
   * @param earrings объект драгоценности, взятый из EarringForm
   * @returns {Promise<*>}
   */
  update = ( earrings ) => this.rest('/earrings/update-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(earrings),
  }).then(() => earrings) // then - заглушка, пока метод ничего не возвращает

}

export default new Earrings();
