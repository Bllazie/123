import Api from '@/api/index';

class Earrings extends Api {

  constructor() {
    super('http://localhost/crud_rest'); // Указываем базовый URL
  }

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
  remove = (id) => {
    const formData = new FormData();
    formData.append('id', id);

    return this.rest('/earrings/delete-item', {
      method: 'POST',
      body: formData
    }).then(response => response.json());
  };

  earringId = (storeID) => this.rest(`/earrings/SelectByID?material=${storeID}`);
  /**
   * Создаст новую запись в таблице
   * @param earring объект блюда, взятый из EarringsForm
   * @returns {Promise<Response>}
   */
  add = (earring) => {

    const formData = new FormData();
    formData.append('name', earring.name);
    formData.append('img_path', earring.img_path);
    formData.append('id_material', earring.id_material);
    formData.append('description', earring.description);
    formData.append('cost', earring.cost);


    return this.rest('/earrings/add-item', {
      method: 'POST',
      body: formData
    }).then(response => response.json());
  };
  /**
   * Отправит измененную запись
   * @param earrings объект драгоценности, взятый из EarringForm
   * @returns {Promise<*>}
   */
  update = ( earring ) => {
    const formData = new FormData();
    formData.append('id', earring.id);
    formData.append('name', earring.name);
    formData.append('img_path', earring.img_path);
    formData.append('id_material', earring.id_material);
    formData.append('description', earring.description);
    formData.append('cost', earring.cost);

    return this.rest('/earrings/update-item', {
      method: 'POST',
      body: formData
    }).then(response => response.json());
  };
}

export default new Earrings();
