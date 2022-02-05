/**
 * Interface to adhere to.
 */
const RepositoryInterface = {
    get () {},
    post () {},
    delete () {}
}

/**
 * Dynamically load a repository file and bind it to the Repository interface.
 * Note: The file must contain .class - ex: myfile.class.js
 *
 * @param {*} fileName The name of the repository file.
 */
const loadRepo = (fileName) => {
    /* Using template literals breaks the dynamic import. /shrug. */
    return bind(() => import('./repositories/' + fileName + '.class'), RepositoryInterface)
}

const bind = (repositoryFactory, Interface) => {
    return {
        ...Object.keys(Interface).reduce((prev, method) => {
            const resolveableMethod = async (...args) => {
                const repository = await repositoryFactory()
                const instance = new repository.default() // eslint-disable-line
                return instance[method](...args)
            }
            return { ...prev, [method]: resolveableMethod }
        }, {})
    }
}

export default {
    get generalRepository () {
        return loadRepo('general')
    },
    get agentSettingsRepository () {
        return loadRepo('agentSettings')
    },
    get listingsSettingsRepository () {
        return loadRepo('listingsSettings')
    },
    get socialProRepository () {
        return loadRepo('socialPro')
    },
    get importContentRepository () {
        return loadRepo('importContent')
    },
    get omnibarRepository () {
        return loadRepo('omnibar')
    }
    /* Add more repositories here as they become available. */
}
