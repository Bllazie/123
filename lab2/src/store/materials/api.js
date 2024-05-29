import Api from '@/api/index';

class Materials extends Api {

  /**
   * Вернет список всех материалов
   * @returns {Promise<Response>}
   */
  materials = () => this.rest('/materials/list.json');

  /**
   * Удалит материал по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = ( id ) => this.rest('/materials/delete-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then(() => id) // then - заглушка, пока метод ничего не возвращает

  /**
   * Создаст новую запись в таблице
   * @param material объект группы, взятый из FormMaterial
   * @returns {Promise<Response>}
   */
  add = ( material ) => this.rest('materials/add-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(material),
  }).then(() => ({...material, id: new Date().getTime()})) // then - заглушка, пока метод ничего не возвращает

  /**
   * Отправит измененную запись
   * @param material объект группы, взятый из FormMaterial
   * @returns {Promise<*>}
   */
  update = ( material ) => this.rest('materials/update-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(material),
  }).then(() => material) // then - заглушка, пока метод ничего не возвращает

}

export default new Materials();
