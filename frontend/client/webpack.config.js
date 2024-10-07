module.exports = {
    resolve: {
        fallback: {
            url: require.resolve("url"),
            querystring: require.resolve("querystring-es3"),
            zlib: require.resolve('browserify-zlib'),
        }
    }
}