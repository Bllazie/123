import Api from '@/api/index';

class Materials extends Api {

    constructor() {
        super('http://localhost/crud_rest'); // Указываем базовый URL
    }
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
    remove = (id) => {
        const formData = new FormData();
        formData.append('id', id);

        return this.rest('/materials/delete-item', {
            method: 'POST',
            body: formData
        }).then(response => response.json());
    };

    /**
     * Создаст новую запись в таблице
     * @param material объект группы, взятый из FormMaterial
     * @returns {Promise<Response>}
     */
    add = (material) => {
        const formData = new FormData();
        formData.append('material_name', material.material_name);//name


        return this.rest('/materials/add-item', {
            method: 'POST',
            body: formData
        }).then(response => response.json());
    };
    /**
     * Отправит измененную запись
     * @param material объект группы, взятый из FormMaterial
     * @returns {Promise<*>}
     */
    update = (material) => {
        const formData = new FormData();
        formData.append('id', material.id);
        formData.append('material_name', material.material_name);//

        return this.rest('/materials/update-item', {
            method: 'POST',
            body: formData
        }).then(response => response.json());
    };
}

export default new Materials();
